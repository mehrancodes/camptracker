<?php

namespace Laravel\Spark\Http\Controllers\Settings\Teams;

use Illuminate\Http\Request;
use Laravel\Spark\Contracts\Interactions\Settings\Teams\UpdateTeamMember;
use Laravel\Spark\Events\Teams\TeamMemberRemoved;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Http\Requests\Settings\Teams\RemoveTeamMemberRequest;

class TeamMemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the given team member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Spark\Team  $team
     * @param  mixed  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $team, $member)
    {
        abort_unless($request->user()->ownsTeam($team), 404);

        $this->interaction($request, UpdateTeamMember::class, [
            $team, $member, $request->all(),
        ]);
    }

    /**
     * Remove the given team member from the team.
     *
     * @param  \Laravel\Spark\Http\Requests\Settings\Teams\RemoveTeamMemberRequest  $request
     * @param  \Laravel\Spark\Team  $team
     * @param  mixed  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(RemoveTeamMemberRequest $request, $team, $member)
    {
        $team->users()->detach($member->id);

        event(new TeamMemberRemoved($team, $member));
    }
}
