@extends('spark::layouts.app')

@section('content')
<div class="tw-container tw-mx-auto tw-px-2">
    <div class="tw-flex tw-justify-center tw--mx-2">
        <div class="tw-w-full md:tw-w-2/3 lg:tw-w-2/4 tw-px-2">
            <div class="tw-bg-gray-100 tw-rounded-lg tw-shadow-sm">
                <div class="tw-py-5 tw-px-3 tw-bg-white tw-border-b tw-rounded-t-lg">{{ __('Verify Your Email Address') }}</div>

                <div class="tw-p-5">

                    @if (session('resent'))
                        <div
                            class="tw-my-2 tw-bg-green-100 tw-border tw-border-green-400 tw-text-green-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
                            role="alert"
                        >
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a class="tw-text-blue-500 hover:tw-text-blue-600" href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
