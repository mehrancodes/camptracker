<?php

namespace App\Providers;

use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;
use Laravel\Spark\Spark;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Small Success',
        'product' => 'Camp Tracker',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'mehrunrasoli@gmail.com';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = false;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     * @throws \Exception
     */
    public function booted()
    {
        Spark::afterLoginRedirectTo('accounts');

        Spark::developers(
            explode(',', env('APP_ADMINS'))
        );

        Spark::useStripe()->noCardUpFront()->trialDays(30);

        Spark::plan('Yearly', 'plan_G4oMnxrKfF6p7q')
            ->price(55)
            ->yearly()
            ->features([
                'Unlimited Projects', 'Unlimited Basecamp Accounts', 'Unlimited Team',
            ]);

        Spark::plan('monthly', 'plan_G4oLC1rUxvFiHT')
            ->price(5)
            ->features([
                'Unlimited Projects', 'Unlimited Basecamp Accounts', 'Unlimited Team',
            ]);
    }
}
