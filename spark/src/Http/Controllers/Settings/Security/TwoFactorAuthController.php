<?php

namespace Laravel\Spark\Http\Controllers\Settings\Security;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Spark\Contracts\Interactions\Settings\Security\DisableTwoFactorAuth;
use Laravel\Spark\Contracts\Interactions\Settings\Security\EnableTwoFactorAuth;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Http\Requests\Settings\Security\EnableTwoFactorAuthRequest;
use Laravel\Spark\Spark;

class TwoFactorAuthController extends Controller
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
     * Enable two-factor authentication for the user.
     *
     * @param  \Laravel\Spark\Http\Requests\Settings\Security\EnableTwoFactorAuthRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function enable(EnableTwoFactorAuthRequest $request)
    {
        try {
            Spark::interact(EnableTwoFactorAuth::class, [
                $request->user(), $request->country_code, $request->phone,
            ]);

            return $this->storeTwoFactorInformation($request);
        } catch (Exception $e) {
            app(ExceptionHandler::class)->report($e);

            return response()->json([
                'errors' => [
                    'phone' => [
                        __('We were not able to enable two-factor authentication for this phone number.'),
                    ],
                ],
            ], 422);
        }
    }

    /**
     * Store the two-factor authentication information on the user instance.
     *
     * @param  \Laravel\Spark\Http\Requests\Settings\Security\EnableTwoFactorAuthRequest  $request
     * @return string
     */
    protected function storeTwoFactorInformation($request)
    {
        $request->user()->forceFill([
            'uses_two_factor_auth' => true,
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'two_factor_reset_code' => bcrypt($code = Str::random(40)),
        ])->save();

        return $code;
    }

    /**
     * Disable two-factor authentication for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request)
    {
        Spark::interact(DisableTwoFactorAuth::class, [$request->user()]);

        $request->user()->forceFill([
            'uses_two_factor_auth' => false,
        ])->save();
    }
}
