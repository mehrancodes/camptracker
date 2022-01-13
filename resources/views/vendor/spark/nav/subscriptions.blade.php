@if (Auth::user()->onTrial())
    <!-- Trial Reminder -->
    <h6 class="tw-block tw-py-2 tw-px-6 tw-text-sm tw-text-gray-600">{{__('Trial')}}</h6>

    <a class="tw-block hover:tw-text-white tw-text-gray-800 tw-px-4 tw-py-2 hover:tw-bg-indigo-500 hover:tw-no-underline" href="/settings#/subscription">
        <i class="fa fa-fw fa-btn fa-shopping-bag tw-mr-2"></i> {{__('Subscribe')}}
    </a>

    <div class="tw-my-2 tw-border-t-1"></div>
@endif

@if (Spark::usesTeams() && Auth::user()->ownsCurrentTeam() && Auth::user()->currentTeamOnTrial())
    <!-- Team Trial Reminder -->
    <h6 class="tw-block tw-py-2 tw-px-6 tw-text-sm tw-text-gray-600">{{__('teams.team_trial')}}</h6>

    <a class="tw-block hover:tw-text-white tw-text-gray-800 tw-px-4 tw-py-2 hover:tw-bg-indigo-500 hover:tw-no-underline" href="/settings/{{ Spark::teamsPrefix() }}/{{ Auth::user()->currentTeam()->id }}#/subscription">
        <i class="fa fa-fw fa-btn fa-shopping-bag tw-mr-2"></i> {{__('Subscribe')}}
    </a>

    <div class="tw-my-2 tw-border-t-1"></div>
@endif
