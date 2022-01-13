@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <h2 class="tw-my-10 tw-text-center tw-text-4xl tw-font-bold tw-text-gray-800">
            {{ $account->name }}<span class="tw-font-normal">'s Todos</span>
        </h2>
        <div class="tw-flex tw-flex-wrap tw--mx-2">
            @if($todos->isNotEmpty())
                @foreach($todos as $todoIndex => $todo)
                    <div class="tw-w-full lg:tw-w-1/3 tw-px-2 tw-mb-4">
                        <a
                            href="{{ route('accounts.projects.todos.show', [$account->id, $project->id, $todo->id]) }}"
                            class="tw-block tw-h-full tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out"
                        >
                            <p class="tw-block tw-p-3 tw-bg-indigo-200 tw-rounded-t-lg tw-text-center tw-text-gray-900 tw-font-medium tw-uppercase">
                                {{ $todo->title }}
                            </p>

                            <div class="tw-py-3">
                                @if ($todo->completed)
                                    <div class="tw-mb-3 tw-text-sm tw-text-center tw-text-gray-700 tw-font-hairline">
                                        <i class="fa fa-check-square-o fa-lg tw-text-green-400"></i> Marked As Done
                                    </div>
                                @else
                                    <div class="tw-mb-3 tw-text-sm tw-text-center tw-text-gray-700 tw-font-hairline">
                                        <i class="fa fa-square-o fa-lg tw-text-green-400"></i> In Progress...
                                    </div>
                                @endif

                                @if ($todo->onlyThreeTrackers->count())
                                    <div class="tw-my-2 tw-mx-32 tw-border-t-1"></div>
                                @endif

                                @foreach($todo->onlyThreeTrackers as $trackerIndex => $tracker)
                                    <div class="tw-flex tw-justify-center tw-items-center tw-py-2 tw-rounded hover:tw-bg-indigo-100 tw-transition-bg tw-transition-150 tw-transition-ease-in-out">
                                        <img class="tw-h-6 tw-h-6 tw-rounded-full tw-mr-2" src="{{ $tracker->developer->avatar }}" alt="Developer's Avatar">
                                        <div class="tw-text-left tw-text-sm">
                                            <p class="tw-text-gray-700">{{ $tracker->developer->name }}</p>
                                            <p class="tw-text-gray-600">{{ $tracker->developer->title }}</p>
                                        </div>
                                        <div class="tw-mx-3 tw-border-l-2 tw-h-8"></div>
                                        <div class="tw-flex tw-inline-flex">
                                            <p class="tw-text-gray-700 tw-mr-1">Duration:</p>
                                            <p class="tw-text-gray-700 tw-font-semibold">{{ timeFromSeconds($tracker->duration) }}</p>
                                        </div>
                                    </div>

                                    @if($trackerIndex+1 < $todo->onlyThreeTrackers->count())
                                        <div class="tw-my-2 tw-mx-10 tw-border-t-1"></div>
                                    @endif
                                @endforeach
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p class="tw-mt-8 tw-text-center tw-text-gray-800">No trackers found for this project yet.</p>
            @endif
        </div>

        {{ $todos->links() }}
    </div>
@endsection
