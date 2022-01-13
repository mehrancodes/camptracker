@extends('spark::layouts.app')

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
@endpush

@section('content')
<spark-register-stripe inline-template>
    <div>
        <div class="spark-screen tw-container tw-mx-auto">
            <!-- Common Register Form Contents -->
            @include('spark::auth.register-common')

            <!-- Billing Information -->
            <div class="tw-flex tw-flex-wrap tw-justify-center tw--mx-2 tw-my-6" v-if="selectedPlan && selectedPlan.price > 0">
                <div class="tw-w-full md:tw-max-w-2xl xl:tw-max-w-3xl tw-px-2">
                    <div class="tw-flex tw-flex-wrap tw-justify-center tw-break-words tw-bg-gray-100 tw-border tw-border-2 tw-rounded tw-shadow-sm">
                        <div class="tw-w-full tw-py-3 tw-px-6 tw-bg-white tw-text-gray-700 tw-border-b">
                            {{__('Billing Information')}}
                        </div>

                        <div class="tw-flex-1 tw-p-6">
                            <!-- Generic 500 Level Error Message / Stripe Threw Exception -->
                            <div
                                class="tw-my-2 tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
                                role="alert"
                                v-if="registerForm.errors.has('form')"
                            >
                                {{__('We had trouble validating your card. It\'s possible your card provider is preventing us from charging the card. Please contact your card provider or customer support.')}}
                            </div>

                            <form role="form">
                                <!-- Cardholder's Name -->
                                <div class="md:tw-flex md:tw-items-center tw-mb-6">
                                    <div class="md:tw-w-2/6">
                                        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="cardHolderName">
                                            {{__('Cardholder\'s Name')}}
                                        </label>
                                    </div>
                                    <div class="md:tw-w-3/6">
                                        <input
                                            v-model="cardForm.name"
                                            class="tw-form-input tw-block tw-w-full"
                                            id="cardHolderName"
                                            type="text"
                                            name="name"
                                        >
                                    </div>
                                </div>

                                <!-- Card Details -->
                                <div class="md:tw-flex md:tw-items-center tw-mb-6">
                                    <div class="md:tw-w-2/6">
                                        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6">
                                            {{__('Card')}}
                                        </label>
                                    </div>
                                    <div class="md:tw-w-3/6">
                                        <div
                                            id="card-element"
                                            class="tw-form-input tw-block tw-w-full"
                                        ></div>
                                        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="cardForm.errors.has('card')">
                                            @{{ cardForm.errors.get('card') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Billing Address Fields -->
                                @include('spark::auth.register-address')
                                @if (Spark::collectsBillingAddress())
                                @endif

                                <!-- ZIP Code -->
                                <div class="md:tw-flex md:tw-items-center tw-mb-6">
                                    <div class="md:tw-w-2/6">
                                        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="zip">
                                            {{__('ZIP / Postal Code')}}
                                        </label>
                                    </div>
                                    <div class="md:tw-w-3/6">
                                        <input
                                            v-model="registerForm.zip"
                                            :class="{'tw-border-red-500': registerForm.errors.has('zip')}"
                                            class="tw-form-input tw-block tw-w-full"
                                            id="zip"
                                            type="text"
                                            name="zip"
                                        >

                                        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('zip')">
                                            @{{ registerForm.errors.get('zip') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Coupon Code -->
                                <div class="md:tw-flex md:tw-items-center tw-mb-6">
                                    <div class="md:tw-w-2/6">
                                        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="coupon">
                                            {{__('Coupon Code')}}
                                        </label>
                                    </div>
                                    <div class="md:tw-w-3/6">
                                        <input
                                            v-model="registerForm.coupon"
                                            :class="{'tw-border-red-500': registerForm.errors.has('coupon')}"
                                            class="tw-form-input tw-block tw-w-full"
                                            id="coupon"
                                            type="text"
                                            name="coupon"
                                        >

                                        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('coupon')">
                                            @{{ registerForm.errors.get('coupon') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Terms And Conditions -->
                                <div class="md:tw-flex md:tw-items-center tw-mb-4">
                                    <div class="md:tw-w-2/6"></div>
                                    <div class="md:tw-w-3/6">
                                        <label class="tw-flex tw-items-center">
                                            <input type="checkbox" class="tw-form-checkbox" v-model="registerForm.terms">
                                            <span class="tw-ml-2">
                                                {!! __('I Accept :linkOpen The Terms Of Service :linkClose', ['linkOpen' => '<a href="/terms" target="_blank">', 'linkClose' => '</a>']) !!}
                                            </span>
                                        </label>

                                        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('terms')">
                                            @{{ registerForm.errors.get('terms') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Tax / Price Information -->
                                <div class="md:tw-flex md:tw-items-center tw-mb-4" v-if="spark.collectsEuropeanVat && countryCollectsVat && selectedPlan">
                                    <div class="md:tw-w-2/6"></div>
                                    <div class="md:tw-w-3/6">
                                        <div
                                            class="tw-my-2 tw-bg-teal-100 tw-border tw-border-teal-500 tw-text-teal-900 tw-px-4 tw-py-3 tw-rounded tw-relative"
                                            role="alert"
                                        >
                                            <strong class="font-bold">{{__('Tax')}}:</strong>
                                            <span class="block sm:inline">@{{ taxAmount(selectedPlan) | currency }}</span>
                                            <br><br>
                                            <strong class="font-bold">{{__('Total Price Including Tax')}}:</strong>
                                            <span class="block sm:inline">
                                                @{{ priceWithTax(selectedPlan) | currency }}
                                                @{{ selectedPlan.type == 'user' && spark.chargesUsersPerSeat ? '/ '+ spark.seatName : '' }}
                                                @{{ selectedPlan.type == 'user' && spark.chargesUsersPerTeam ? '/ '+ __('teams.team') : '' }}
                                                @{{ selectedPlan.type == 'team' && spark.chargesTeamsPerSeat ? '/ '+ spark.teamSeatName : '' }}
                                                @{{ selectedPlan.type == 'team' && spark.chargesTeamsPerMember ? '/ '+ __('teams.member') : '' }}
                                                / @{{ __(selectedPlan.interval) | capitalize }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Register Button -->
                                <div class="md:tw-flex md:tw-items-center">
                                    <div class="md:tw-w-2/6"></div>
                                    <div class="md:tw-w-3/6">
                                        <button
                                            :disabled="registerForm.busy"
                                            class="tw-btn tw-btn-primary"
                                            @click.prevent="register"
                                        >
                                            <span v-if="registerForm.busy">
                                                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Registering')}}
                                            </span>

                                            <span v-else>
                                                <i class="fa fa-btn fa-check-circle"></i> {{__('Register')}}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tw-flex tw-justify-center">
                Wanna see prices first?
                <a class="tw-ml-1 tw-font-bold tw-text-indigo-500" href="/pricing">Here's Pricing</a>
            </div>
        </div>

        <!-- Plan Features Modal -->
        @include('spark::modals.plan-details')
    </div>
</spark-register-stripe>
@endsection
