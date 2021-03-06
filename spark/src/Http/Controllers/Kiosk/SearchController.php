<?php

namespace Laravel\Spark\Http\Controllers\Kiosk;

use Illuminate\Http\Request;
use Laravel\Spark\Contracts\Repositories\UserRepository;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Spark;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('dev');
    }

    /**
     * Get the users based on the incoming search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function performBasicSearch(Request $request)
    {
        $query = str_replace('*', '%', $request->input('query'));

        return Spark::interact(UserRepository::class.'@search', [
            $query, $request->user(),
        ]);
    }
}
