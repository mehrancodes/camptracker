@extends('layouts.app')

@section('content')
	<div class="tw-container tw-mx-auto tw-px-2">
		<div class="tw-flex tw-flex-col">
			<div class="tw-my-10 tw-text-4xl tw-font-bold tw-text-gray-900 tw-text-center">Let's Add Your Basecamp Projects!</div>

			<div class="tw-w-full tw-p-6">
				<div class="tw-flex tw-justify-center">
					<div class="tw-w-full md:tw-w-1/2">
						@if($projects->isEmpty())
							<div class="tw-text-center">Hmmm, seems you don't have any new projects that need to be added.</div>
						@else
							<form class="tw-flex tw-flex-col tw--mx-2" method="post" action="{{ route('accounts.projects.store', $account->id) }}">
								@csrf

								<div class="tw-text-center">
									Choose the projects you want to be tracked from your <span class="tw-font-bold">{{ $account->name }}</span> Basecamp
								</div>

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
									@foreach($projects as $project)
										<div class="tw-flex tw-items-center tw-py-2 tw-px-4 tw-my-4 tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
											<label class="tw-mr-4">
												<input type="checkbox" name="projects[]" value="{{ $project->id }}" class="tw-form-checkbox tw-text-blue-600 tw-h-6 tw-w-6">
											</label>

											<div class="tw-flex tw-flex-col">
												<p class="tw-my-1 tw-text-gray-800 tw-font-bold tw-text-lg">{{ $project->name }}</p>
												<a class="tw-my-1 tw-underline tw-text-blue-600" href="{{ $project->app_url }}" target="_blank">{{ $project->app_url }}</a>
											</div>
										</div>
									@endforeach
								</div>

								<div class="tw-flex tw-mt-6 tw-justify-center">
									<button type="submit" class="tw-py-3 tw-px-10 tw-btn tw-btn-default">
										Add Chosen projects
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
