<?php

namespace Laravel\Spark\Http\Controllers\Settings\Teams;

use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Spark;

class TeamMemberRoleController extends Controller
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
     * Get the available team member roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $roles = [];

        foreach (Spark::roles() as $key => $value) {
            $roles[] = ['value' => $key, 'text' => $value];
        }

        return response()->json($roles);
    }
}
