<?php

namespace App\Http\Controllers;

use App\Account;
use App\Developer;
use App\Project;
use App\Todo;
use App\Tracker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Account $account
     * @return void
     */
    public function index(Account $account)
    {
        abort_unless(Gate::allows('access-account', $account), 403);

        $account->load('developers');

        return view('activities', compact('account'));
    }

    /**
     * Response a list of projects in a date range.
     *
     * @param Request $request
     * @param Developer $developer
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function projects(Request $request, Developer $developer)
    {
        abort_unless(Gate::allows('user-access-developer', $developer), 404);

        $dateRange = $this->getDateRangesQuery($request);

        $projects = Project::whereHas('trackers', function ($query) use ($dateRange, $developer) {
            $query->where('developer_id', $developer->id)
                ->whereBetween('created_at', $dateRange);
        })->paginate(10);

        return response()->json($projects);
    }

    /**
     * Response a list of todos in a date range.
     *
     * @param Request $request
     * @param Developer $developer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function todos(Request $request, Developer $developer)
    {
        abort_unless(Gate::allows('user-access-developer', $developer), 404);

        $dateRange = $this->getDateRangesQuery($request);

        $todos = Todo::whereHas('trackers', function ($query) use ($dateRange, $developer) {
            $query->where('developer_id', $developer->id)
                ->whereBetween('created_at', $dateRange);
        })
            ->with('project')
            ->paginate(10);

        return response()->json($todos);
    }

    /**
     * @param Request $request
     * @param Developer $developer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function activities(Request $request, Developer $developer)
    {
        abort_unless(Gate::allows('user-access-developer', $developer), 404);

        $dateRange = $this->getDateRangesQuery($request);

        // All todos during this date range
        $todos = Todo::whereHas('trackers', function ($query) use ($dateRange, $developer) {
            $query->where('developer_id', $developer->id)
                ->whereBetween('created_at', $dateRange);
        })->get();

        // Don't go further if developer didn't
        if ($todos->isEmpty()) {
            return response()->json([]);
        }

        // Hours spent
        $hours = Tracker::where('developer_id', $developer->id)
            ->whereBetween('created_at', $dateRange)
            ->sum('duration');
        $hoursSpent = timeFromSeconds($hours);

        // Todos completed
        $todosCompleted = $todos->where('completed', true)->count();

        // Todos in progress
        $todosInProgress = $todos->where('completed', false)->count();

        // Projects participated in
        $projectsParticipatedIn = Project::whereHas('trackers', function ($query) use ($dateRange, $developer) {
            $query->where('developer_id', $developer->id)
                ->whereBetween('created_at', $dateRange);
        })->count();

        // Todos participated in
        $todosParticipatedIn = $todos->count();

        return response()->json([
            'data' => [
                'hoursSpent' => $hoursSpent,
                'todosCompleted' => $todosCompleted,
                'todosInProgress' => $todosInProgress,
                'projectsParticipatedIn' => $projectsParticipatedIn,
                'todosParticipatedIn' => $todosParticipatedIn,
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    protected function getDateRangesQuery(Request $request): array
    {
        return [
            (new Carbon($request->query('startDate')))->startOfDay(),
            (new Carbon($request->query('endDate')))->endOfDay(),
        ];
    }
}
