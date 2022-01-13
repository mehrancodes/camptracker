<?php

namespace Laravel\Spark\Listeners\Subscription;

use Braintree\Subscription as BraintreeSubscription;
use Laravel\Cashier\BraintreeService;

class UpdateTaxPercentageOnBraintree
{
    /**
     * Handle the event.
     *
     * @param  mixed  $event
     * @return void
     */
    public function handle($event)
    {
        $subscription = $event->billable->subscription();

        if (! $subscription || ! $subscription->valid()) {
            return;
        }

        $plan = BraintreeService::findPlan($subscription->braintree_plan);

        BraintreeSubscription::update($subscription->braintree_id, [
            'price' => $plan->price * (1 + ($event->billable->taxPercentage() / 100)),
            'options' => [
                'prorateCharges' => false,
            ],
        ]);
    }
}
