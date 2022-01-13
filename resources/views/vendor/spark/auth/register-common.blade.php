<div class="tw-flex tw-flex-row tw-justify-center">
    <div class="tw-w-full tw-max-w-2xl">
        <!-- Coupon -->
        <div
            class="tw-my-2 tw-bg-green-100 tw-border tw-border-green-400 tw-text-green-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
            role="alert"
            v-if="coupon"
        >
            <?php echo __('The coupon :value discount will be applied to your subscription!', ['value' => '{{ discount }}']); ?>
        </div>

        <!-- Invalid Coupon -->
        <div
            class="tw-my-2 tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
            role="alert"
            v-if="invalidCoupon"
        >
            {{__('Whoops! This coupon code is invalid.')}}
        </div>

        <!-- Invitation -->
        <div
            class="tw-my-2 tw-bg-green-100 tw-border tw-border-green-400 tw-text-green-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
            role="alert"
            v-if="invitation"
        >
            <?php echo __('teams.we_found_invitation_to_team', ['teamName' => '{{ invitation.team.name }}']); ?>
        </div>

        <!-- Invalid Invitation -->
        <div
            class="tw-my-2 tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
            role="alert"
            v-if="invalidInvitation"
        >
            {{__('Whoops! This invitation code is invalid.')}}
        </div>
    </div>
</div>

<!-- Plan Selection -->
<div class="tw-flex tw-flex-wrap tw-justify-center tw--mx-2 tw-my-6" v-if="paidPlans.length > 0 && !registerForm.invitation">
    <div class="tw-w-full md:tw-max-w-2xl xl:tw-max-w-3xl tw-px-2">
        <div class="tw-flex tw-flex-wrap tw-justify-center tw-break-words tw-bg-gray-100 tw-border tw-border-2 tw-rounded tw-shadow-sm">
            <div class="tw-w-full tw-bg-white tw-text-gray-700 tw-py-3 tw-px-6 tw-mb-0">
                {{__('Subscription')}}

                <!-- Interval Selector Button Group -->
                <div class="tw-inline-flex tw-float-right" v-if="hasMonthlyAndYearlyPlans">

                    <!-- Monthly Plans -->
                    <button
                        class="tw-bg-gray-200 hover:tw-bg-gray-400 tw-text-gray-700 focus:tw-outline-none tw-text-sm tw-py-1 tw-px-2 tw-rounded-l"
                        @click="showMonthlyPlans"
                        :class="{'tw-bg-gray-400 tw-border tw-border-gray-400': showingMonthlyPlans}"
                    >
                        {{__('Monthly')}}
                    </button>

                    <!-- Yearly Plans -->
                    <button
                        class="tw-bg-gray-200 hover:tw-bg-gray-400 tw-text-gray-700 focus:tw-outline-none tw-text-sm tw-py-1 tw-px-2 tw-rounded-r"
                        @click="showYearlyPlans"
                        :class="{'tw-bg-gray-400 tw-border tw-border-gray-400': showingYearlyPlans}"
                    >
                        {{__('Yearly')}}
                    </button>
                </div>
            </div>

            <div class="tw-w-full tw-overflow-auto">
                <!-- Plan Error Message - In General Will Never Be Shown -->
                <div
                    class="tw-m-4 tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
                    role="alert"
                    v-if="registerForm.errors.has('plan')"
                >
                    @{{ registerForm.errors.get('plan') }}
                </div>

                <!-- European VAT Notice -->
                @if (Spark::collectsEuropeanVat())
                    <p class="tw-m-4">
                        {{__('All subscription plan prices are excluding applicable VAT.')}}
                    </p>
                @endif

                <table class="tw-table-auto tw-w-full">
                    <tbody>
                    <tr v-for="plan in plansForActiveInterval">
                        <!-- Plan Name -->
                        <td class="tw-py-3 tw-px-6 tw-border-t tw-border-grey-light">
                            <label class="tw-inline-flex tw-items-center" @click="selectPlan(plan)">
                                <input
                                    :value="plan.name"
                                    :checked="isSelected(plan)"
                                    type="radio"
                                    class="tw-form-radio tw-h-6 tw-w-6"
                                    name="plans"
                                >
                                <span class="tw-ml-2">@{{ plan.name }}</span>
                            </label>
                        </td>

                        <!-- Plan Features Button -->
                        <td class="tw-py-3 tw-px-6 tw-border-t tw-border-grey-light">
                            <button class="tw-btn tw-btn-default"
                                    @click="showPlanDetails(plan)"
                            >
                                <i class="fa fa-btn fa-star-o"></i> {{__('Features')}}
                            </button>
                        </td>

                        <!-- Plan Price -->
                        <td class="tw-py-3 tw-px-6 tw-border-t tw-border-grey-light">
                                <span v-if="plan.price == 0" class="tw-text-gray-600">
                                    {{__('Free')}}
                                </span>

                            <span v-else class="tw-text-gray-600">
                                <strong class="tw-text-gray-700 tw-font-bold">@{{ plan.price | currency }}</strong>
                                @{{ plan.type == 'user' && spark.chargesUsersPerSeat ? '/ '+ spark.seatName : '' }}
                                @{{ plan.type == 'user' && spark.chargesUsersPerTeam ? '/ '+ __('teams.team') : '' }}
                                @{{ plan.type == 'team' && spark.chargesTeamsPerSeat ? '/ '+ spark.teamSeatName : '' }}
                                @{{ plan.type == 'team' && spark.chargesTeamsPerMember ? '/ '+ __('teams.member') : '' }}
                                / @{{ __(plan.interval) | capitalize }}
                            </span>
                        </td>

                        <!-- Trial Days -->
                        <td class="tw-py-3 tw-px-6 tw-border-t tw-border-grey-light tw-text-right">
                            <span class="tw-text-gray-700 tw-font-bold" v-if="plan.trialDays">
                                <?php echo __(':trialDays Day Trial', ['trialDays' => '{{ plan.trialDays }}']); ?>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Basic Profile -->
<div class="tw-flex tw-flex-wrap tw-justify-center tw--mx-2 tw-my-6">
    <div class="tw-w-full md:tw-max-w-2xl xl:tw-max-w-3xl tw-px-2">
        <div class="tw-flex tw-flex-wrap tw-justify-center tw-break-words tw-bg-gray-100 tw-border tw-border-2 tw-rounded tw-shadow-sm">
            <div class="tw-w-full tw-py-3 tw-px-6 tw-bg-white tw-text-gray-700 tw-border-b">
                <span v-if="paidPlans.length > 0">
                    {{__('Profile')}}
                </span>

                <span v-else>
                    {{__('Register')}}
                </span>
            </div>

            <div class="tw-flex-1 tw-p-6">
                <!-- Generic Error Message -->
                <div
                    class="tw-my-2 tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
                    role="alert"
                    v-if="registerForm.errors.has('form')"
                >
                    @{{ registerForm.errors.get('form') }}
                </div>

                <!-- Invitation Code Error -->
                <div
                    class="tw-my-2 tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
                    role="alert"
                    v-if="registerForm.errors.has('invitation')"
                >
                    @{{ registerForm.errors.get('invitation') }}
                </div>

                <!-- Registration Form -->
                @include('spark::auth.register-common-form')
            </div>
        </div>
    </div>
</div>
