<?php

namespace Laravel\Spark\Http\Controllers\Settings\Billing;

use Braintree\WebhookNotification;
use Illuminate\Http\Response;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Laravel\Spark\Contracts\Repositories\LocalInvoiceRepository;
use Laravel\Spark\Events\Subscription\SubscriptionCancelled;
use Laravel\Spark\Events\Teams\Subscription\SubscriptionCancelled as TeamSubscriptionCancelled;
use Laravel\Spark\TeamSubscription;

class BraintreeWebhookController extends WebhookController
{
    use SendsInvoiceNotifications;

    /**
     * Handle a successful invoice payment from a Braintree subscription.
     *
     * By default, this e-mails a copy of the invoice to the customer.
     *
     * @param  \Braintree\WebhookNotification  $webhook
     * @return \Illuminate\Http\Response
     */
    protected function handleSubscriptionChargedSuccessfully($webhook)
    {
        $subscription = $this->getSubscriptionById($webhook->subscription->id);

        if (! $subscription || ! isset($webhook->subscription->transactions[0])) {
            return $this->teamSubscriptionChargedSuccessfully($webhook);
        }

        $invoice = $subscription->user->findInvoice(
            $webhook->subscription->transactions[0]->id
        );

        app(LocalInvoiceRepository::class)->createForUser(
            $subscription->user, $invoice
        );

        $this->sendInvoiceNotification($subscription->user, $invoice);
    }

    /**
     * Handle a successful invoice payment from a Braintree subscription.
     *
     * @param  \Braintree\WebhookNotification  $webhook
     * @return \Illuminate\Http\Response
     */
    protected function teamSubscriptionChargedSuccessfully($webhook)
    {
        $subscription = TeamSubscription::where(
            'braintree_id', $webhook->subscription->id
        )->first();

        if (! $subscription || ! isset($webhook->subscription->transactions[0])) {
            return;
        }

        $invoice = $subscription->team->findInvoice(
            $webhook->subscription->transactions[0]->id
        );

        app(LocalInvoiceRepository::class)->createForTeam(
            $subscription->team, $invoice
        );

        $this->sendInvoiceNotification($subscription->team, $invoice);
    }

    /**
     * Handle a subscription cancellation notification from Braintree.
     *
     * @param  string  $subscriptionId
     * @return \Illuminate\Http\Response
     */
    protected function cancelSubscription($subscriptionId)
    {
        parent::cancelSubscription($subscriptionId);

        if (! $this->getSubscriptionById($subscriptionId)) {
            return $this->cancelTeamSubscription($subscriptionId);
        }

        if ($subscription = $this->getSubscriptionById($subscriptionId)) {
            event(new SubscriptionCancelled($subscription->user));
        }

        return new Response('Webhook Handled', 200);
    }

    /**
     * Handle a subscription cancellation notification from Braintree.
     *
     * @param  string  $subscriptionId
     * @return \Illuminate\Http\Response
     */
    protected function cancelTeamSubscription($subscriptionId)
    {
        $subscription = TeamSubscription::where(
            'braintree_id', $subscriptionId
        )->first();

        if ($subscription && ! $subscription->cancelled()) {
            $subscription->markAsCancelled();

            event(new TeamSubscriptionCancelled($subscription->team));
        }

        return new Response('Webhook Handled', 200);
    }
}
