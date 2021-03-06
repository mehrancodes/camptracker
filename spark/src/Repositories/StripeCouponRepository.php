<?php

namespace Laravel\Spark\Repositories;

use Exception;
use Laravel\Spark\Contracts\Repositories\CouponRepository;
use Laravel\Spark\Coupon;
use Laravel\Spark\Spark;
use Stripe\Coupon as StripeCoupon;

class StripeCouponRepository implements CouponRepository
{
    /**
     * {@inheritdoc}
     */
    public function valid($code)
    {
        return ! is_null($this->find($code));
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
        try {
            $coupon = StripeCoupon::retrieve(
                $code, ['api_key' => config('services.stripe.secret')]
            );

            if ($coupon && $coupon->valid) {
                return $this->toCoupon($coupon);
            }
        } catch (Exception $e) {
            //
        }
    }

    /**
     * {@inheritdoc}
     */
    public function forBillable($billable)
    {
        if (! $billable->stripe_id) {
            return;
        }

        $customer = $billable->asStripeCustomer();

        if ($customer->discount && $customer->discount->coupon) {
            return $this->toCoupon($customer->discount->coupon);
        }
    }

    /**
     * Convert the given Stripe coupon into a Coupon instance.
     *
     * @param  \Stripe\Coupon  $coupon
     * @return \Laravel\Spark\Coupon
     */
    protected function toCoupon($coupon)
    {
        return new Coupon(
            $coupon->duration, $coupon->duration_in_months,
            $coupon->amount_off, $coupon->percent_off
        );
    }
}
