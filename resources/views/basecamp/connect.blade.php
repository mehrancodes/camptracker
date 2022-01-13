@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <div class="tw-flex tw-items-center tw-justify-center tw-content-center">
            <div class="tw-w-full md:tw-w-1/2">
                <div class="tw-text-4xl tw-font-bold tw-text-gray-800 tw-text-center">Let's get started!</div>
                <div class="tw-mt-4 tw-text-2xl tw-text-gray-800 tw-leading-snug tw-text-center">First step, connect your basecamp account.</div>
                <p class="tw-mt-4 tw-text-sm tw-text-center tw-leading-relaxed">
                    By clicking on the button below you'll be directed to the Basecamp and there you'll be asked to give the access to the Camp Tracker to read your Accounts, Projects and Todos.
                </p>

                <div class="tw-flex tw-flex-wrap tw-justify-center tw-mt-8">
                    <a
                        href="{{ route('basecamp.integrate') }}"
                        class="tw-block sm:tw-inline-flex tw-items-center tw-py-2 tw-btn tw-border tw-border-green-400 tw-text-green-400 tw-bg-green-100 hover:tw-bg-green-200"
                    >
                        <img class="tw-float-left tw-mr-4 tw-h-10 tw-w-10" src="{{ asset('/img/basecamp_logo.svg') }}" alt="basecamp logo">
                        <span class="tw-flex tw-flex-col tw-text-left">
                            <span class="tw-text-sm tw-font-thin tw-text-green-500">Connect Camp Tracker to your</span>
                            <span class="tw-block tw-mt-1 tw-text-xl sm:tw-text-2xl tw-text-green-500 tw-font-bold">Basecamp account</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
