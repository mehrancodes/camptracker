<?php

namespace App\Http\Controllers;

use App\Account;
use App\Events\ProjectCreated;
use App\Project;
use Basecamp;
use Belvedere\Basecamp\IndexCollection;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Account $account
     * @return Response
     */
    public function index(Account $account)
    {
        abort_unless(Gate::allows('access-account', $account), 403);

        $account->load(['projects.developers', 'projects' => function ($project) {
            $project->withCount('todos');
        }]);

        $account->projects->each(function ($project) {
            $project->onlyFiveDevelopers();
        });

        return view('projects.index', compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Account $account
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Account $account)
    {
        abort_unless(Gate::allows('access-account', $account), 403);

        $user = auth()->user();

        try {
            $projects = $this->getBasecampProjects($account, $user);
            $projects = $this->filterStoredProjects($projects, $user);
        } catch (\Exception $exception) {
            return redirect()->back()
                ->with('flash', ['message' => "Seems there's an issue with your basecamp account! Make sure everything is alright.", 'type' => 'error']);
        }

        return view('projects.create', compact('account', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Account $account
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Account $account)
    {
        abort_unless(Gate::allows('access-account', $account), 403);

        $request->validate([
            'projects' => 'required|array',
        ], [
            'required' => 'At least one project should be chosen.',
        ]);

        $user = auth()->user();
        $projectIds = $request->get('projects');
        $basecampProjects = $this->getBasecampProjects($account, $user);

        foreach ($projectIds as $id) {
            $bcProject = $basecampProjects->first(function ($project) use ($id) {
                return $project->id == $id;
            });

            $project = Project::updateOrCreate(
                ['account_id' => $account->id, 'basecamp_id' => $bcProject->id],
                [
                    'user_id' => $user->id,
                    'name' => $bcProject->name,
                    'url' => $bcProject->app_url,
                ]
            );

            // Generate a webhook for the project on Basecamp
            event(new ProjectCreated($account, $project, $user));
        }

        return redirect()
            ->route('accounts.projects.index', $account->id)
            ->with('flash', 'The chosen basecamp projects have been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @param Project $project
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Account $account, Project $project)
    {
        abort_unless(Gate::allows('access-account', $account), 403);
        abort_unless(Gate::allows('access-project', [$account, $project]), 404);

        // Get the associated project with its todos and developers
        $project->load('onlyTenTodos', 'onlyTenDevelopers');

        $project->onlyTenTodos->each(function ($todo) {
            $todo->load('onlyThreeTrackers.developer');
        });

        return view('projects.show', compact('account', 'project'));
    }

    /**
     * @param Account $account
     * @param Authenticatable $user
     * @return IndexCollection
     */
    protected function getBasecampProjects(Account $account, Authenticatable $user)
    {
        if (! Cache::tags(["user.{$user->id}", "account.{$account->id}"])->has('projects')) {
            $this->initBasecamp($account, $user);

            $basecamp = Basecamp::projects();
            $projects = $basecamp->index();
            $data = collect();

            // Abort if no basecamp project exist
            abort_if($projects->isEmpty(), 403, "Didn't find any project for this Basecamp.");

            // Handle the pagination to get all the projects
            if ($projects->nextPage()) {
                do {
                    $data = $data->merge($projects->all());

                    $nextPage = $projects->nextPage();
                    $projects = $basecamp->index($nextPage);
                } while ($nextPage);
            } else {
                $data = $data->merge($projects->all());
            }

            Cache::tags(["user.{$user->id}", "account.{$account->id}"])->put('projects', $data, 120);
        }

        $data = Cache::tags(["user.{$user->id}", "account.{$account->id}"])->get('projects');

        return $data;
    }

    /**
     * Filter the basecamp projects which already exists in the database.
     *
     * @param $projects
     * @param $user
     * @return mixed
     */
    protected function filterStoredProjects($projects, $user)
    {
        return $projects->filter(function ($project) use ($user) {
            $itDoesntExistsInDB = Project::where('basecamp_id', $project->id)->doesntExist();

            return $itDoesntExistsInDB;
        });
    }

    /**
     * @param Account $account
     * @param Authenticatable $user
     */
    protected function initBasecamp(Account $account, Authenticatable $user)
    {
        Basecamp::init([
            'id' => $account->basecamp_id,
            'href' => $account->href,
            'token' => $user->token,
            'refresh_token' => $user->refresh_token,
        ]);

        Basecamp::setCache(Cache::store('redis'));

        Basecamp::setMiddlewares([
            \GuzzleHttp\Middleware::log(
                app('log')->getLogger(),
                new \GuzzleHttp\MessageFormatter('{method} {uri} HTTP/{version} {req_body}')
            ),
        ]);
    }
}
