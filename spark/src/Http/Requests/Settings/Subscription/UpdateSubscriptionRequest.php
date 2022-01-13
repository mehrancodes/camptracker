<?php

namespace Laravel\Spark\Http\Requests\Settings\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Laravel\Spark\Spark;

class UpdateSubscriptionRequest extends FormRequest
{
    use DeterminesPlanEligibility;

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
            'plan' => 'required|in:'.Spark::activePlanIdList(),
        ]);

        return $validator->after(function ($validator) {
            $this->validatePlanEligibility($validator);
        });
    }
}
