<?php

namespace Laravel\Spark\Http\Controllers\Settings\API;

use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Spark;

class TokenAbilitiesController extends Controller
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
     * Get all of the available token abilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(collect(Spark::tokensCan())->map(function ($value, $key) {
            return [
                'name' => $value,
                'value' => $key,
                'default' => in_array($key, Spark::tokenDefaults()),
            ];
        })->values());
    }
}
