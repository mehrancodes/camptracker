@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">

        <div class="tw-mt-4 tw-mb-12 tw-text-center tw-text-4xl md:tw-text-4xl tw-text-gray-800">Hours spent by <span class="tw-font-bold">{{ $developer->name }}</span></div>
        <div class="tw-flex tw-flex-wrap tw--mx-2">
            <div class="tw-w-full md:tw-w-1/3 tw-px-2">
                <div class="tw-bg-white tw-border tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                    <div class="tw-font-medium tw-text-gray-900 tw-text-center tw-py-3 tw-bg-indigo-200 tw-rounded-t-lg tw-uppercase">Today</div>
                    <p class="tw-my-8 tw-text-center tw-text-lg tw-text-gray-700">{{ $workDoneToday }} {{ \Illuminate\Support\Str::plural('Hour', $workDoneToday) }}</p>
                </div>
            </div>
            <div class="tw-w-full md:tw-w-1/3 tw-px-2 tw-mt-2 md:tw-mt-0">
                <div class="tw-bg-white tw-border tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                    <div class="tw-font-medium tw-text-gray-900 tw-text-center tw-py-3 tw-bg-indigo-200 tw-rounded-t-lg tw-uppercase">This Week</div>
                    <p class="tw-my-8 tw-text-center tw-text-lg tw-text-gray-700">{{ $workDoneThisWeek }} {{ \Illuminate\Support\Str::plural('Hour', $workDoneThisWeek) }}</p>
                </div>
            </div>
            <div class="tw-w-full md:tw-w-1/3 tw-px-2 tw-mt-2 md:tw-mt-0">
                <div class="tw-bg-white tw-border tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                    <div class="tw-font-medium tw-text-gray-900 tw-text-center tw-py-3 tw-bg-indigo-200 tw-rounded-t-lg tw-uppercase">This Month</div>
                    <p class="tw-my-8 tw-text-center tw-text-lg tw-text-gray-700">{{ $workDoneThisMonth }} {{ \Illuminate\Support\Str::plural('Hour', $workDoneThisMonth) }}</p>
                </div>
            </div>
        </div>

        <div class="tw-my-10 tw-border-t-2 tw-border-dashed"></div>

        <div class="tw-mb-12 tw-text-center tw-text-4xl md:tw-text-4xl tw-text-gray-800">Recent activities on this basecamp</div>
        <div class="tw-flex tw-flex-wrap tw--mx-2">
            <div class="tw-w-full md:tw-w-1/3 tw-px-2">
                <div class="tw-my-3 tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                    <div class="tw-font-medium tw-text-gray-900 tw-text-center tw-py-3 tw-bg-indigo-200 tw-rounded-t-lg tw-uppercase">Last 10 projects participated In</div>

                    <div class="tw-flex tw-flex-col tw-p-2 tw-leading-relaxed tw-text-center">
                        @foreach($developer->lastTenProjects as $projectIndex => $project)
                            <a
                                class="tw-py-2 tw-px-4 tw-text-lg md:tw-text-base tw-text-blue-600 hover:tw-bg-indigo-100"
                                href="{{ route('accounts.projects.show', [$account->id, $project->id]) }}"
                            >
                                {{ $project->name }}
                            </a>

                            @if($projectIndex+1 < $developer->lastTenProjects->count())
                                <div class="tw-my-2 tw-mx-8 tw-border-t-1"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tw-w-full md:tw-w-1/3 tw-px-2 tw-mt-10 md:tw-mt-0">
                <div class="tw-my-3 tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                    <div class="tw-font-medium tw-text-gray-900 tw-text-center tw-py-3 tw-bg-indigo-200 tw-rounded-t-lg tw-uppercase">Last 10 todos participated In</div>

                    <ul class="tw-flex tw-flex-col tw-p-2 tw-leading-snug tw-text-center">
                        @foreach($developer->lastTenTodos as $todoIndex => $todo)
                            <a
                                class="tw-py-2 tw-px-4 tw-text-lg md:tw-text-base tw-text-blue-600 hover:tw-bg-indigo-100"
                                href="{{ route('accounts.projects.todos.show', [$account->id, $todo->project->id, $todo->id]) }}"
                            >
                                {{ $todo->title }}
                            </a>

                            @if($todoIndex+1 < $developer->lastTenTodos->count())
                                <div class="tw-my-2 tw-mx-8 tw-border-t-1"></div>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tw-w-full md:tw-w-1/3 tw-px-2 tw-mt-10 md:tw-mt-0">
                <div class="tw-my-3 tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                    <div class="tw-font-medium tw-text-gray-900 tw-text-center tw-py-3 tw-bg-indigo-200 tw-rounded-t-lg tw-uppercase">Last 10 times spent on</div>

                    <ul class="ftw-lex tw-flex-col tw-p-2 tw-leading-snug tw-text-center">
                        @foreach($developer->lastTenTrackers as $trackerIndex => $tracker)
                            <div class="tw-py-2 tw-px-4 tw-text-lg md:tw-text-base tw-text-gray-800 hover:tw-bg-indigo-100" href="#">
                                <span class="tw-font-bold">{{ timeFromSeconds($tracker->duration) }}</span> on
                                <a class="tw-text-blue-600 hover:tw-no-underline" href="{{ route('accounts.projects.todos.show', [$account->id, $tracker->project->id, $tracker->todo->id]) }}">{{ $tracker->todo->title }}</a>
                            </div>

                            @if($trackerIndex+1 < $developer->lastTenTrackers->count())
                                <div class="tw-my-2 tw-mx-8 tw-border-t-1"></div>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
