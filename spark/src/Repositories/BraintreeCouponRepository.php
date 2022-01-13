<?php

namespace Laravel\Spark\Repositories;

use Braintree\Discount as BraintreeDiscount;
use Laravel\Spark\Contracts\Repositories\CouponRepository;
use Laravel\Spark\Coupon;
use Laravel\Spark\Spark;

class BraintreeCouponRepository implements CouponRepository
{
    /**
     * {@inheritdoc}
     */
    public function valid($code)
    {
        return $code === 'plan-credit' ? false : ! is_null($this->find($code));
    }

    /**
     * {@inheritdoc}
     */
    public function canBeRedeemed($code)
    {
        return $this->valid($code) && Spark::promotion() !== $code;
    }

    /**
     * {@inheritdoc}
     */
    public function find($code)
    {
        $discounts = BraintreeDiscount::all();

        foreach ($discounts as $discount) {
            if ($discount->id === $code) {
                return $this->toCoupon($discount);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function forBillable($billable)
    {
        if ($billable->subscribed()) {
            $subscription = $billable->subscription()->asBraintreeSubscription();

            if (! empty($subscription->discounts)) {
                return $this->toCoupon($subscription->discounts[0]);
            }
        }
    }

    /**
     * Convert the given Braintree discount into a Coupon instance.
     *
     * @param  \Braintree\Discount  $discount
     * @return \Laravel\Spark\Coupon
     */
    protected function toCoupon($discount)
    {
        return new Coupon(
            $discount->neverExpires ? 'forever' : 'repeating',
            $discount->numberOfBillingCycles, $discount->amount
        );
    }
}
