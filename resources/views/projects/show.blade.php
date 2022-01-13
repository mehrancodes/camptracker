@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <h2 class="tw-my-10 tw-text-4xl tw-font-bold tw-text-gray-900 tw-text-center">{{ $project->name }}<span class="tw-font-normal">'s todos & developers</span></h2>
        <div class="tw-flex tw-flex-wrap tw--mx-2">
            <div class="tw-w-full md:tw-w-2/3 tw-px-2">
                <h2 class="tw-my-4 tw-text-center tw-text-2xl tw-text-gray-800">TODOS</h2>
                @if($project->onlyTenTodos->isNotEmpty())
                    <div class="tw-flex tw-flex-wrap tw--mx-2">
                        @foreach($project->onlyTenTodos as $todoIndex => $todo)
                            <div class="tw-w-full lg:tw-w-1/2 tw-px-2 tw-mb-4">
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
                    </div>

                    @if($project->onlyTenTodos->count() === 10)
                        <a
                                class="tw-block tw-mt-3 tw-text-gray-700 tw-text-center tw-underline hover:tw-text-blue-600"
                                href="{{ route('accounts.projects.todos.index', [$account->id, $project->id]) }}"
                        >
                            See all todos
                        </a>
                    @endif
                @else
                    <div class="tw-p-4 tw-bg-white tw-rounded tw-shadow-sm">
                        <p class="tw-text-center tw-text-gray-700">No trackers found for this project yet.</p>
                    </div>
                @endif
            </div>

            <div class="tw-w-full md:tw-w-1/3 tw-my-10 tw-px-2 md:tw-my-0">
                <h2 class="tw-my-4 tw-text-center tw-text-2xl tw-text-gray-800">DEVELOPERS</h2>
                @if($project->onlyTenDevelopers->isNotEmpty())
                    @foreach($project->onlyTenDevelopers as $developerIndex => $developer)
                        <div class="tw-p-2 tw-mb-4 tw-bg-white tw-rounded tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                                <a
                                    class="tw-flex tw-items-center tw-py-2 tw-pl-5 tw-rounded"
                                    href="{{ route('accounts.developers.show', [$account->id, $developer->id]) }}"
                                >
                                    <img class="tw-h-12 tw-rounded-full tw-mr-4" src="{{ $developer->avatar }}" alt="Developer's Avatar">
                                    <span class="tw-text-left">
                                        <span class="tw-block tw-text-gray-700">{{ $developer->name }}</span>
                                        <span class="tw-block tw-text-gray-600 tw-text-xs lg:tw-text-sm">{{ $developer->title }}</span>
                                    </span>
                                </a>
                        </div>
                    @endforeach

                    @if($project->onlyTenDevelopers->count() === 10)
                        <a
                                class="tw-block tw-mt-5 tw-text-gray-700 tw-text-center tw-underline hover:tw-text-blue-600"
                                href="{{ route('accounts.projects.developers.index', [$account->id, $project->id]) }}"
                        >
                            See all developers
                        </a>
                    @endif
                @else
                    <div class="tw-p-4 tw-bg-white tw-rounded tw-shadow-sm">
                        <p class="tw-text-center tw-text-gray-700">No developers found for this project yet.</p>
                    </div>
                @endif
            </div>

            <div class="tw-w-full md:tw-w-2/4 tw-px-2 tw-mx-auto tw-mt-24 md:wt-mt-32 lg:tw-mt-56 tw-mb-4">
                <p class="tw-text-sm tw-text-gray-700 tw-leading-snug">Tip: Tell your team to add a comment to the Todo they want to track hours associated with, like this:</p>
                <div class="tw-p-4 tw-mt-2 tw-bg-blue-100 tw-rounded tw-leading-snug">
                    <p class="tw-font-light tw-text-sm tw-text-gray-700">// Required: hours they spent on this Todo.</p>
                    <p class="tw-text-gray-800">#HOURS=1:30</p>

                    <p class="tw-mt-3 tw-font-light tw-text-sm tw-text-gray-700">// Optional: describe what they've been working on.</p>
                    <p class="tw-text-gray-800">#NOTE="Write up to 255 characters"</p>
                </div>
            </div>
        </div>
    </div>
@endsection
