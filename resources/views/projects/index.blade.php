@extends('layouts.app')

@section('content')
	<div class="tw-container tw-mx-auto tw-px-2">
		<h2 class="tw-my-8 tw-text-4xl tw-font-bold tw-text-gray-900 tw-text-center">{{ $account->name }}<span class="tw-font-normal">'s projects</span></h2>

		@if($account->projects->isEmpty())
			<div class="tw-px-6 tw-py-10 tw-text-center tw-leading-relaxed">
				<p class="tw-text-gray-900 tw-text-2xl">
					Let's import your current projects!
				</p>
				<p class="tw-w-full lg:tw-w-2/4 tw-inline-block tw-text-gray-700 tw-mt-6">
					Import the projects you want Camp Tracker to track the hours your team spend on todos.
				</p>

				<div class="tw-flex tw-flex-wrap tw-mt-8 tw-justify-center">
					<a
							href="{{ route('accounts.projects.create', $account->id) }}"
							class="tw-py-3 tw-px-10 tw-btn tw-btn-default"
					>
						Import Projects
					</a>
				</div>
			</div>
		@else
			<div class="tw-flex tw-flex-col">
				<div class="tw-w-full tw-px-6 tw-py-4 tw-text-center tw-leading-relaxed">
					<p class="tw-text-gray-900 tw-text-2xl">
						Your projects are all here!
					</p>
					<p class="tw-text-gray-800 tw-mt-3">
						Click on one of the projects below to see how much your team has worked on their assigned todos.
					</p>
				</div>

				<div class="tw-px-2">
                    <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-mt-6 tw-px-10 xl:tw-mx-32">
                        <div class="tw-w-full sm:tw-w-2/6 tw-text-center sm:tw-text-left">
                            <p class="tw-text-gray-600">PROJECT</p>
                        </div>

                        <div class="tw-w-full sm:tw-w-1/6 tw-mt-6 sm:tw-mt-0 tw-text-center sm:tw-text-left">
                            <p class="tw-text-gray-600">TODOS</p>

                        </div>

                        <div class="tw-w-full sm:tw-w-2/6 tw-mt-6 sm:tw-mt-0 tw-pr-0 sm:tw-pr-2 tw-text-center sm:tw-text-left">
                            <p class="tw-text-gray-600">DEVELOPERS</p>
                        </div>

                        <div class="tw-w-full sm:tw-w-1/6 tw-mt-6 sm:tw-mt-0 tw-text-center sm:tw-text-left">
                            <p class="tw-text-gray-600">ACTIONS</p>
                        </div>
                    </div>

                    @foreach($account->projects as $project)
                        <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-py-6 tw-px-10 tw-my-4 xl:tw-mx-32 tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out tw-break-all">
                            <div class="tw-w-full sm:tw-w-2/6 tw-text-center sm:tw-text-left">
                                <p class="tw-font-medium">{{ $project->name }}</p>
                            </div>

                            <div class="tw-w-full sm:tw-w-1/6 tw-mt-6 sm:tw-mt-0 tw-text-center sm:tw-text-left">
                                <p class="tw-font-medium">{{ $project->todos_count }} {{ \Illuminate\Support\Str::plural('todo', $project->todos_count) }}</p>
                            </div>

                            <div class="tw-w-full sm:tw-w-2/6 tw-mt-6 sm:tw-mt-0 tw-pr-0 sm:tw-pr-2 tw-text-center sm:tw-text-left">
                                <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-center sm:tw-justify-start">
                                    @foreach($project->developers as $developer)
                                        <img class="tw-h-5 tw-h-5 tw-rounded-full tw-mr-1 tw-mt-1" src="{{ $developer->avatar }}" alt="Developer's Avatar">
                                    @endforeach

                                    @if($project->developers === 5)
                                        <i class="fa fa-user-plus tw-text-gray-700"></i>
                                    @endif
                                </div>
                            </div>

                            <div class="tw-w-full sm:tw-w-1/6 tw-mt-6 sm:tw-mt-0 tw-text-center sm:tw-text-left">
                                <a class="tw-btn tw-btn-default tw-block sm:tw-inline tw-mt-2 sm:tw-mt-0" href="{{ route('accounts.projects.show', [$account->id, $project->id]) }}">
                                    Trackers
                                </a>
                            </div>
                        </div>
                    @endforeach

				</div>
                <div class="tw-mt-20 tw-text-center">
                    <div class="tw-text-gray-700">Need to import another project or is a project missing?</div>
                    <a
                        class="tw-btn tw-btn-default tw-inline-block tw-mt-6 tw-py-3 tw-px-10"
                        href="{{ route('accounts.projects.create', $account->id) }}"
                    >
                        Let's Import It
                    </a>
                </div>
			</div>
		@endif
    </div>
@endsection
