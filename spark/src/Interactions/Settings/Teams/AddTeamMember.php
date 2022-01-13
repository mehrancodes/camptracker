<?php

namespace Laravel\Spark\Interactions\Settings\Teams;

use Laravel\Spark\Contracts\Interactions\Settings\Teams\AddTeamMember as Contract;
use Laravel\Spark\Events\Teams\TeamMemberAdded;
use Laravel\Spark\Spark;

class AddTeamMember implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function handle($team, $user, $role = null)
    {
        $team->users()->attach($user, ['role' => $role ?: Spark::defaultRole()]);

        event(new TeamMemberAdded($team, $user));
    }
}
