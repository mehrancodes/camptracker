@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <div class="tw-flex tw-flex-col">
            <div class="tw-my-10 tw-text-4xl tw-font-bold tw-text-gray-900 tw-text-center">Let's start with Adding Your Accounts!</div>

            <div class="tw-w-full tw-p-6">
                <div class="tw-flex tw-justify-center">
                    <div class="tw-w-full md:tw-w-1/2">
                        @if($accounts->isEmpty())
                            <h2 class="tw-text-center">Hmmm, seems you don't have any new Basecamp account to be added.</h2>
                        @else
                            <form class="tw-flex tw-flex-col tw--mx-2" method="post" action="{{ route('accounts.store') }}">
                                @csrf

                                <h2 class="tw-text-center">Choose the Basecamps you want to be tracked</h2>

                                @if ($errors->any())
                                    <div class="tw-mt-4">
                                        <div class="tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-rounded tw-relative" role="alert">
                                            <p class="tw-font-semibold">Whoops! There were some problems with your input.</p>

                                            <ul class="tw-mt-5 tw-list-disc tw-list-inside tw-leading-snug">
                                                @foreach ($errors->all() as $error)
                                                    <li class="tw-ml-5">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                <div class="tw-w-full tw-py-2">
                                    @foreach($accounts as $account)
                                        <div class="tw-flex tw-items-center tw-py-2 tw-px-4 tw-my-4 tw-bg-white tw-border tw-border-2 tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out tw-break-all">
                                            @if ( ! $account['exists'])
                                                <label class="tw-mr-4">
                                                    <input type="checkbox" name="basecamps[]" value="{{ $account['id'] }}" class="tw-form-checkbox tw-text-blue-600 tw-h-6 tw-w-6">
                                                </label>
                                            @endif

                                            <div class="tw-flex tw-flex-col">
                                                <p class="tw-my-1 tw-text-gray-800 tw-font-bold tw-text-lg">
                                                    {{ $account['name'] }}

                                                    @if ($account['exists'])
                                                        <span class="tw-text-gray-600 tw-font-thin tw-text-sm">Already registered!</span>
                                                    @endif
                                                </p>

                                                <a class="tw-my-1 tw-underline tw-text-blue-600" href="{{ $account['app_href'] }}" target="_blank">{{ $account['app_href'] }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="tw-flex tw-mt-6 tw-justify-center">
                                    <button type="submit" class="tw-py-3 tw-px-10 tw-btn tw-btn-default">
                                        Add Chosen accounts
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
