<?php

namespace Laravel\Spark\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Spark\Spark;

class TaxRateController extends Controller
{
    /**
     * Attempt to calculate the tax rate for the billing address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request)
    {
        if (! $request->filled('city', 'state', 'zip', 'country')) {
            return response()->json(['rate' => 0]);
        }

        $user = Spark::user();

        $user->forceFill([
            'vat_id' => $request->vat_id,
            'billing_city' => $request->city,
            'billing_state' => $request->state,
            'billing_zip' => $request->zip,
            'billing_country' => $request->country,
            'card_country' => $request->country,
        ]);

        return response()->json([
            'rate' => $user->taxPercentage(),
        ]);
    }
}
