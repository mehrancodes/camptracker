<?php

namespace Laravel\Spark\Http\Controllers\Kiosk;

use Illuminate\Http\Request;
use Laravel\Spark\Contracts\Repositories\PerformanceIndicatorsRepository;
use Laravel\Spark\Contracts\Repositories\UserRepository;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Spark;

class ProfileController extends Controller
{
    /**
     * The performance indicators repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\PerformanceIndicatorsRepository
     */
    protected $indicators;

    /**
     * Create a new controller instance.
     *
     * @param  \Laravel\Spark\Contracts\Repositories\PerformanceIndicatorsRepository  $indicators
     * @return void
     */
    public function __construct(PerformanceIndicatorsRepository $indicators)
    {
        $this->indicators = $indicators;

        $this->middleware('auth');
        $this->middleware('dev');
    }

    /**
     * Get the user to be displayed on the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = Spark::call(UserRepository::class.'@find', [$id]);

        return response()->json([
            'user' => $user,
            'revenue' => $this->indicators->totalRevenueForUser($user),
        ]);
    }
}
