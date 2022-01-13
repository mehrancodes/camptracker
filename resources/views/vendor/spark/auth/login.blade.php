@extends('spark::layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <div class="tw-flex tw-flex-wrap tw-justify-center tw--mx-2">
            <div class="tw-w-full tw-max-w-2xl tw-px-2">
                <div class="tw-flex tw-flex-wrap tw-justify-center tw-break-words tw-bg-white tw-border tw-border-2 tw-rounded tw-shadow-md">

                    <div class="tw-w-full tw-bg-gray-200 tw-text-gray-700 tw-py-3 tw-px-6 tw-mb-0">
                        {{ __('Login') }}
                    </div>

                    @include('spark::shared.errors')

                    <form class="tw-w-full tw-max-w-xl tw-p-6" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="md:tw-flex md:tw-items-center tw-mb-6">
                            <div class="md:tw-w-1/3">
                                <label class="tw-block tw-text-gray-500 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-4" for="email">
                                    {{ __('E-Mail Address') }}
                                </label>
                            </div>
                            <div class="md:tw-w-2/3">
                                <input
                                    class="tw-form-input tw-block tw-w-full {{ $errors->any() ? 'tw-border-red-500' : '' }}"
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="md:tw-flex md:tw-items-center tw-mb-4">
                            <div class="md:tw-w-1/3">
                                <label class="tw-block tw-text-gray-500 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-4" for="password">
                                    {{ __('Password') }}
                                </label>
                            </div>
                            <div class="md:tw-w-2/3">
                                <input
                                    class="tw-form-input tw-block tw-w-full {{ $errors->any() ? 'tw-border-red-500' : '' }}"
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        <div class="md:tw-flex md:tw-items-center tw-mb-4">
                            <div class="md:tw-w-1/3"></div>
                            <label class="md:tw-w-2/3 tw-block tw-text-gray-500">
                                <input class="tw-form-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <span class="tw-text-sm tw-text-gray-700 tw-ml-2">
                                    {{ __('Remember Me') }}
                                </span>
                            </label>
                        </div>


                        <div class="md:tw-flex md:tw-items-center tw-mb-4">
                            <div class="md:tw-w-1/3"></div>
                            <div class="md:tw-w-2/3">
                                <button type="submit" class="tw-btn tw-btn-primary">
                                    <i class="fa fa-sm fa-sign-in tw-mr-2"></i>
                                    {{ __('LOGIN') }}
                                </button>

                                @if (Route::has('password.reset'))
                                    <a class="md:tw-w-2/3 sm:tw-ml-2 tw-text-sm tw-text-blue-500 hover:tw-text-blue-700 tw-whitespace-no-wrap tw-no-underline" href="{{ route('password.reset') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
