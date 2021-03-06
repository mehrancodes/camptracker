<?php

namespace Laravel\Spark\Http\Controllers\Settings\Teams\Subscription;

use Illuminate\Http\Request;
use Laravel\Spark\Contracts\Http\Requests\Settings\Teams\Subscription\CreateSubscriptionRequest;
use Laravel\Spark\Contracts\Interactions\SubscribeTeam;
use Laravel\Spark\Events\Teams\Subscription\SubscriptionCancelled;
use Laravel\Spark\Events\Teams\Subscription\SubscriptionUpdated;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Http\Requests\Settings\Teams\Subscription\UpdateSubscriptionRequest;
use Laravel\Spark\Spark;
use Laravel\Spark\Team;

class PlanController extends Controller
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
     * Create the subscription for the team.
     *
     * @param  \Laravel\Spark\Contracts\Http\Requests\Settings\Teams\Subscription\CreateSubscriptionRequest  $request
     * @param  \Laravel\Spark\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSubscriptionRequest $request, Team $team)
    {
        Spark::interact(SubscribeTeam::class, [
            $team, $request->plan(), false, $request->all(),
        ]);
    }

    /**
     * Update the subscription for the team.
     *
     * @param  \Laravel\Spark\Http\Requests\Settings\Teams\Subscription\UpdateSubscriptionRequest  $request
     * @param  \Laravel\Spark\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriptionRequest $request, Team $team)
    {
        $plan = $request->plan();

        // This method is used both for updating subscriptions and for resuming cancelled
        // subscriptions that are still within their grace periods as this swap method
        // will be used for either of these situations without causing any problems.
        if ($plan->price === 0) {
            return $this->destroy($request, $team);
        } else {
            $subscription = $team->subscription();

            if (Spark::chargesTeamsPerMember() || Spark::chargesTeamsPerSeat()) {
                $subscription->forceFill([
                    'quantity' => Spark::teamSeatsCount($team),
                ])->save();
            }

            if (Spark::prorates()) {
                $subscription->swap($request->plan);
            } else {
                $subscription->noProrate()->swap($request->plan);
            }
        }

        event(new SubscriptionUpdated(
            $team->fresh()
        ));
    }

    /**
     * Cancel the team's subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Spark\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Team $team)
    {
        abort_unless($request->user()->ownsTeam($team), 403);

        $team->subscription()->cancel();

        event(new SubscriptionCancelled($team->fresh()));
    }
}
