<?php

namespace Laravel\Spark\Http\Controllers\Settings\PaymentMethod;

use Illuminate\Http\Request;
use Laravel\Spark\Contracts\Repositories\UserRepository;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Spark;

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
     * Update the VAT ID for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'vat_id' => 'max:50|vat_id',
        ]);

        Spark::call(UserRepository::class.'@updateVatId', [
            $request->user(), $request->vat_id,
        ]);
    }
}
