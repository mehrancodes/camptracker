<?php

namespace Laravel\Spark\Http\Requests\Settings\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Laravel\Spark\Contracts\Http\Requests\Settings\PaymentMethod\UpdatePaymentMethodRequest;
use Laravel\Spark\Http\Requests\ValidatesBillingAddresses;
use Laravel\Spark\Spark;

class UpdateStripePaymentMethodRequest extends FormRequest implements UpdatePaymentMethodRequest
{
    use ValidatesBillingAddresses;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validator for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator()
    {
        $validator = Validator::make($this->all(), [
            'stripe_token' => 'required',
        ]);

        if (Spark::collectsBillingAddress()) {
            $this->validateBillingAddress($validator);
        }

        return $validator;
    }
}
