<?php

namespace App\Http\Controllers;

use App\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user()
            ->load(['accounts' => function ($account) {
                $account->withCount('projects');
            }]);

        return view('accounts.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function create()
    {
        $user = auth()->user();
        $accounts = Cache::tags(['user'.$user->id, 'basecamp'])->get('accounts');

        if (is_null($accounts)) {
            return $this->authorizeUser();
        }

        $accounts = $this->filterStoredAccounts($accounts, $user);

        // abort if no basecamp account exist
        abort_if(
            $accounts->isEmpty(),
            403,
            "Sorry, didn't find any Basecamp account that could be added."
        );

        return view('accounts.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Exception
     */
    public function store(Request $request)
    {
        $user = auth()->user()
            ->load('accounts');

        $request->validate([
            'basecamps' => 'required|array',
            'basecamps.*' => [
                'distinct',
                'unique:accounts,basecamp_id',
            ],
        ], [
            'required' => 'At least one basecamp should be chosen.',
            'unique' => 'The chosen Basecamp has already been taken.',
        ]);

        $accounts = Cache::tags(['user'.$user->id, 'basecamp'])->get('accounts');
        $accountIds = $request->get('basecamps');

        if (is_null($accounts)) {
            return $this->authorizeUser();
        }

        foreach ($accountIds as $id) {
            $account = $accounts->firstWhere('id', $id);

            $user->accounts()->create([
                'basecamp_id' => $account['id'],
                'name' => $account['name'],
                'href' => $account['href'],
            ]);
        }

        return redirect('/accounts')->with('flash', 'The chosen basecamp accounts have been added successfully.');
    }

    /**
     * Filter the basecamp accounts which already exists in the database.
     *
     * @param $accounts
     * @param $user
     * @return mixed
     */
    protected function filterStoredAccounts($accounts, $user)
    {
        return $accounts->map(function ($account) use ($user) {
            $itDoesntExistsInDB = Account::where('basecamp_id', $account['id'])->exists();

            $itDoesntExistsInDB ? $account['exists'] = true : $account['exists'] = false;

            return $account;
        });
    }

    /**
     * Authorize the socialite user when needed.
     *
     * @return mixed
     */
    protected function authorizeUser()
    {
        return Socialite::driver('37signals')
            ->with(['type' => 'web_server'])
            ->redirect();
    }
}
