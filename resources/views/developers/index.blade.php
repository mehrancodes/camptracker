@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <h2 class="tw-my-10 tw-text-center tw-text-4xl tw-font-bold tw-text-gray-800">{{ $account->name }}<span class="tw-font-normal">'s Developers</span></h2>
        <div class="tw-flex tw-flex-wrap tw--mx-2">
            @if($developers->isNotEmpty())
                @foreach($developers as $developerIndex => $developer)
                    <div class="tw-w-full sm:tw-w-1/2 md:tw-w-1/3 lg:tw-w-1/4 tw-p-2 md:tw-my-0">
                        <div class="tw-p-2 tw-bg-white tw-rounded tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                            <a
                                class="tw-flex tw-flex-col tw-justify-center tw-items-center tw-py-2 tw-p-2 tw-mb-4"
                                href="{{ route('accounts.developers.show', [$account->id, $developer['id']]) }}"
                            >
                                <img class="tw-h-12 tw-h-12 tw-rounded-full" src="{{ $developer['avatar'] }}" alt="Developer's Avatar">
                                <div class="tw-text-center tw-mt-3 tw-mt-0 tw-text-left">
                                    <p class="tw-text-gray-700">{{ $developer['name'] }}</p>
                                    <p class="tw-text-gray-600 tw-text-sm">{{ $developer['title'] }}</p>
                                </div>

                                <p class="tw-w-2/3 tw-mt-4 tw-leading-tight tw-text-center tw-text-sm tw-text-gray-700">
                                    Worked <span class="font-bold">{{ timeFromSeconds($developer->trackers->sum('duration')) }} hours</span>
                                </p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="tw-mt-8 tw-text-center tw-text-gray-800">No developers found for this project yet.</p>
            @endif
        </div>

        {{ $developers->links() }}
    </div>
@endsection
