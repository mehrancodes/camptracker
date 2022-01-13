@extends('spark::layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <div class="tw-flex tw-flex-wrap tw-justify-center tw--mx-2">
            <div class="tw-w-full tw-max-w-2xl tw-px-2">
                <div class="tw-flex tw-flex-wrap tw-justify-center tw-break-words tw-bg-white tw-border tw-border-2 tw-rounded tw-shadow-md">

                    <div class="tw-w-full tw-bg-gray-200 tw-text-gray-700 tw-py-3 tw-px-6 tw-mb-0">
                        {{__('Login Via Emergency Token')}}
                    </div>

                    @include('spark::shared.errors')

                    <!-- Warning Message -->
                    <div class="tw-m-6 tw-bg-orange-100 tw-border tw-text-yellow-800 tw-px-4 tw-py-3 tw-rounded tw-relative" role="alert">
                        {{__('After logging in via your emergency token, two-factor authentication will be disabled for your account. If you would like to maintain two-factor authentication security, you should re-enable it after logging in.')}}
                    </div>

                    <form class="tw-w-full tw-max-w-xl tw-p-6" method="POST" action="/login-via-emergency-token">
                        @csrf

                        <!-- Emergency Token -->
                        <div class="md:tw-flex md:tw-items-center tw-mb-6">
                            <div class="md:w-1/3">
                                <label class="tw-block tw-text-gray-700 mb-2 pr-4" for="token">
                                    {{__('Emergency Token')}}
                                </label>
                            </div>
                            <div class="md:tw-w-2/3">
                                <input
                                    class="tw-form-input tw-block tw-w-full {{ $errors->has('token') ? 'tw-border-red-500' : '' }}"
                                    id="token"
                                    type="password"
                                    value="{{ old('token') }}"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        <div class="tw-flex tw-flex-wrap">
                            <button type="submit" class="tw-btn tw-btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
