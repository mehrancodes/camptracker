<?php

namespace App\Http\Controllers;

use App\Account;
use App\Developer;
use App\Project;
use App\Tracker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DevelopersController extends Controller
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
        abort_unless(Gate::allows('access-project', [$account, $project]), 404);

        $developers = $project->developers()
            ->with('trackers')
            ->paginate(16);

        return view('developers.index', compact('account', 'project', 'developers'));
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @param \App\Developer $developer
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Account $account, Developer $developer)
    {
        abort_unless(Gate::allows('access-account', $account), 403);
        abort_unless(Gate::allows('access-developer', [$account, $developer]), 404);

        $developer->load(
            'lastTenProjects',
            'lastTenTodos.project',
            'lastTenTrackers.todo',
            'lastTenTrackers.project'
        );

        list($workDoneToday, $workDoneThisWeek, $workDoneThisMonth) = $this->sumHoursWork($developer, $account);

        return view(
            'developers.show',
            compact('account', 'developer', 'workDoneToday', 'workDoneThisWeek', 'workDoneThisMonth')
        );
    }

    /**
     * Sum uo the hours worked by the given developer...
     *
     * @param Developer $developer
     * @param Account   $account
     *
     * @return array
     */
    protected function sumHoursWork(Developer $developer, Account $account): array
    {
        $workDoneToday = Tracker::where('developer_id', $developer->id)
            ->where('account_id', $account->id)
            ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
            ->sum('duration');

        $workDoneThisWeek = Tracker::where('developer_id', $developer->id)
            ->where('account_id', $account->id)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('duration');

        $workDoneThisMonth = Tracker::where('developer_id', $developer->id)
            ->where('account_id', $account->id)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum('duration');

        return [
            timeFromSeconds($workDoneToday),
            timeFromSeconds($workDoneThisWeek),
            timeFromSeconds($workDoneThisMonth),
        ];
    }
}
