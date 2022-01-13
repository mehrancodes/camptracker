<?php

namespace Laravel\Spark\Interactions\Settings\Security;

use Laravel\Spark\Contracts\Interactions\Settings\Security\DisableTwoFactorAuth as Contract;
use Laravel\Spark\Services\Security\Authy;

class DisableTwoFactorAuthUsingAuthy implements Contract
{
    /**
     * The Authy service instance.
     *
     * @var \Laravel\Spark\Services\Security\Authy
     */
    protected $authy;

    /**
     * Create a new interaction instance.
     *
     * @param  \Laravel\Spark\Services\Security\Authy  $authy
     * @return void
     */
    public function __construct(Authy $authy)
    {
        $this->authy = $authy;
    }

    /**
     * {@inheritdoc}
     */
    public function handle($user)
    {
        $this->authy->disable($user->authy_id);

        $user->forceFill([
            'authy_id' => null,
        ])->save();

        return $user;
    }
}
