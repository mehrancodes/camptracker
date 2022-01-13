<?php

namespace Laravel\Spark\Http\Controllers\Settings\Teams\PaymentMethod;

use Illuminate\Http\Request;
use Laravel\Spark\Contracts\Repositories\TeamRepository;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Spark;
use Laravel\Spark\Team;

class VatIdController extends Controller
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
     * Update the VAT ID for the team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Spark\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $this->validate($request, [
            'vat_id' => 'max:50|vat_id',
        ]);

        Spark::call(TeamRepository::class.'@updateVatId', [
            $team, $request->vat_id,
        ]);
    }
}
