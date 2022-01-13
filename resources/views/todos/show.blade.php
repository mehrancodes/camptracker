@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <h2 class="tw-my-8 tw-text-4xl tw-text-gray-900 tw-text-center tw-leading-snug lg:tw-text-2xl"><span class="tw-font-bold">{{ $todo->title }}</span>'s trackers</h2>
        <div class="tw-w-full tw-px-2">
            <div class="tw-flex tw-items-center tw-justify-center">
                <div class="tw-w-full tw-py-6 tw-text-center tw-bg-white tw-rounded-lg tw-shadow-sm">
                    <p class="tw-px-4 tw-text-xl tw-text-gray-700">
                        <span class="tw-font-bold">{{ $hoursWorkedOnThisTodo }} hours</span> work done on this todo
                        by the {{ \Illuminate\Support\Str::plural('developer', $developers->count()) }} bellow
                    </p>

                    <div class="tw-mt-4">
                        @foreach($developers as $developerIndex => $developer)
                            <a
                                    class="tw-inline-flex tw-items-center tw-justify-center tw-my-2 tw-p-2 tw-text-blue-600 hover:tw-bg-blue-100 tw-rounded tw-transition-bg tw-transition-150 tw-transition-ease-in-out"
                                    href="{{ route('accounts.developers.show', [$account->id, $developer->id]) }}"
                            >
                                <img class="tw-h-8 tw-h-8 tw-rounded-full tw-mr-2" src="{{ $developer->avatar }}" alt="Developer's Avatar">
                                {{ $developer->name }} worked
                                <span class="tw-font-bold tw-ml-1">
                                    {{ timeFromSeconds($developer->trackers->sum('duration')) }}
                                    {{ \Illuminate\Support\Str::plural('hour', timeFromSeconds($developer->trackers->sum('duration'))) }}
                                    </span>
                            </a>
                            @if($developerIndex+1 < $developers->count())
                                <div class="tw-my-2 tw-mx-8 tw-border-t-1"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tw-flex tw-flex-wrap tw--mx-2 tw-mt-3">
                @foreach($trackers as $trackerIndex => $tracker)
                    <div class="tw-w-full sm:tw-w-1/2 md:tw-w-1/3 lg:tw-w-1/4 tw-px-2 tw-my-2">
                        <div class="tw-p-2 tw-h-full tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                            <div class="tw-flex tw-flex-wrap tw-justify-center tw-items-center tw-p-2">
                                <div class="tw-flex tw-flex-col tw-items-center">
                                    <div class="tw-flex tw-flex-wrap tw-items-center">
                                        <img class="tw-h-12 tw-h-12 tw-rounded-full tw-mr-2" src="{{ $tracker->developer->avatar }}" alt="Developer's Avatar">

                                        <div class="tw-mt-2 tw-text-left">
                                            <p class="tw-text-gray-800">{{ $tracker->developer->name }}</p>
                                            <p class="tw-text-gray-700 tw-text-sm">{{ $tracker->developer->title }}</p>
                                        </div>
                                    </div>

                                    <p class="tw-text-gray-700 tw-mt-6">Duration <span class="font-semibold">{{ timeFromSeconds($tracker->duration) }}</span></p>
                                    <p class="tw-text-gray-700 tw-text-sm">{{ $tracker->created_at->toFormattedDateString() }}</p>
                                </div>

                                <div class="tw-w-full tw-text-center">
                                    <div class="tw-my-4 tw-border-t-1"></div>
                                    @if($tracker->description)
                                        <p class="tw-text-gray-600 tw-leading-snug">{{ $tracker->description }}</p>
                                    @else
                                        <p class="tw-text-gray-600">No description...</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $trackers->links() }}
        </div>
    </div>
@endsection
