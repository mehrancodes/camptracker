<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class BaseCampController extends Controller
{
    /**
     * Display the basecamp connect page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = auth()->user();

        // redirect to homepage if basecamp account is connected
        if ($user->has_basecamp_connected) {
            return redirect()->route('accounts.index');
        }

        return view('basecamp.connect', compact('user'));
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('37signals')
            ->with(['type' => 'web_server'])
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     * @throws Throwable
     */
    public function handleProviderCallback()
    {
        try {
            $basecamp = Socialite::driver('37signals')->user();
        } catch (\Exception $e) {
            return redirect()->route('basecamp.connect');
        }

        $accounts = collect($basecamp->user['accounts'])
            ->where('product', 'bc3');

        $user = $this->updateUser($basecamp);

        // Cache the user accounts to use later
        Cache::tags(['user'.$user->id, 'basecamp'])->put('accounts', $accounts, 600);

        // Get Redirect link
        $redirectTo = $this->sessionHasPreviousUrl() ? session()->previousUrl() : route('accounts.index');

        return redirect($redirectTo);
    }

    /**
     * Update the user model with basecamp account info.
     *
     * @param $basecamp
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @throws Throwable
     */
    protected function updateUser($basecamp)
    {
        $user = Auth::user();

        $user->update([
            'basecamp_id' => $basecamp->id,
            'name' => $basecamp->name,
            'token' => $basecamp->token,
            'refresh_token' => $basecamp->refreshToken,
            'expires_at' => Carbon::parse($basecamp->user['expires_at']),
        ]);

        return $user;
    }

    /**
     * @return bool
     */
    protected function sessionHasPreviousUrl(): bool
    {
        return session()->previousUrl() && session()->previousUrl() !== route('basecamp.integrate');
    }
}
