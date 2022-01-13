@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <div class="tw-my-10 tw-text-center tw-text-4xl tw-text-gray-800">All your Basecamp accounts are here</div>
        @if($user->accounts->isEmpty())
            <div class="tw-mt-4 tw-text-center tw-text-gray-800">Hmm, seems you don't have any new Basecamp account added yet.</div>
            <div class="tw-mt-4 tw-text-center tw-text-lg tw-text-gray-700">Let's start by adding your accounts!</div>
            <div class="tw-flex tw-justify-center tw-mt-6 tw-mb-2">
                <a class="tw-btn tw-btn-default" href="{{ url('/accounts/create') }}">
                    Add my accounts
                </a>
            </div>
        @else

            <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-px-10 xl:tw-mx-32">
                <div class="tw-w-full sm:tw-w-6/12 tw-text-center sm:tw-text-left">
                    <p class="tw-text-gray-600">BASECAMP</p>
                </div>

                <div class="tw-w-full sm:tw-w-5/12 md:tw-w-4/12 lg:tw-w-3/12 tw-mt-6 sm:tw-mt-0 tw-text-center sm:tw-text-left">
                    <p class="tw-text-gray-600">ACTIONS</p>
                </div>
            </div>

            @foreach($user->accounts as $account)
                <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-py-6 tw-px-10 tw-my-4 xl:tw-mx-32 tw-bg-white tw-border tw-border-2 tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out tw-break-all">
                    <div class="tw-w-full sm:tw-w-6/12 tw-text-center sm:tw-text-left">
                        <p class="tw-font-medium">{{ $account->name }}</p>
                    </div>

                    <div class="tw-w-full sm:tw-w-5/12 md:tw-w-4/12 lg:tw-w-3/12 tw-mt-6 sm:tw-mt-0 tw-text-center sm:tw-text-left">
                        @if(!$account->projects_count)
                            <a
                                class="tw-btn tw-btn-default tw-block sm:tw-inline tw-mt-2 sm:tw-mt-0"
                                href="{{ route('accounts.projects.index', $account->id) }}"
                            >
                                IMPORT PROJECTS
                            </a>
                        @else
                            <a class="tw-btn tw-btn-default tw-block sm:tw-inline tw-mt-2 sm:tw-mt-0 sm:tw-mr-2" href="{{ route('accounts.activities.index', $account->id) }}">
                                Activities
                            </a>

                            <a class="tw-btn tw-btn-default tw-block sm:tw-inline tw-mt-2 sm:tw-mt-0" href="{{ route('accounts.projects.index', $account->id) }}">
                                Projects
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="tw-mt-20 tw-text-center">
                <div class="tw-text-gray-700">Need to add another Basecamp account?</div>
                <a
                    class="tw-btn tw-btn-default tw-inline-block tw-mt-6 tw-py-3 tw-px-10"
                    href="{{ route('accounts.create') }}"
                >
                    Let's Add It
                </a>
            </div>
        @endif
    </div>
@endsection
