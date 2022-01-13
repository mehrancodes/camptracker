<?php

namespace App\Http\Controllers;

use App\Account;
use App\Project;
use App\Todo;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Account $account
     * @param Project $project
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Account $account, Project $project)
    {
        abort_unless(Gate::allows('access-account', $account), 403);

        $todos = $project->todos()
            ->orderByDesc('updated_at')
            ->paginate(9);

        $todos->each(function ($todo) {
            /* @var $todo Todo */
            return $todo->load('onlyThreeTrackers.developer');
        });

        return view('todos.index', compact('account', 'project', 'todos'));
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @param Project $project
     * @param Todo $todo
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Account $account, Project $project, Todo $todo)
    {
        abort_unless(Gate::allows('access-account', $account), 403);
        abort_unless(Gate::allows('access-todo', [$account, $project, $todo]), 404);

        $todo->load(
            [
                'developers.trackers' => function ($tracker) use ($todo) {
                    $tracker->where('todo_id', $todo->id);
                },
                'trackers',
            ]
        );

        $hoursWorkedOnThisTodo = timeFromSeconds($todo->trackers->sum('duration'));

        // Remove the duplicate developers
        $developers = $todo->developers->unique('id');

        // Paginate the trackers
        $trackers = $todo->trackers()
            ->orderBy('developer_id', 'asc')
            ->with('developer')
            ->paginate(16);

        return view(
            'todos.show',
            compact('account', 'project', 'todo', 'trackers', 'developers', 'hoursWorkedOnThisTodo')
        );
    }
}
