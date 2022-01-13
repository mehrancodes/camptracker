<!-- Teams -->
<h6 class="tw-block tw-py-2 tw-px-6 tw-text-sm tw-text-gray-600">{{ __('teams.teams')}}</h6>

<!-- Create Team -->
@if (Spark::createsAdditionalTeams())
    <a class="tw-block hover:tw-text-white tw-text-gray-800 tw-px-4 tw-py-2 hover:tw-bg-indigo-500 hover:tw-no-underline" href="/settings#/{{Spark::teamsPrefix()}}">
        <i class="fa fa-fw fa-btn fa-plus-circle tw-mr-2"></i> {{__('teams.create_team')}}
    </a>
@endif

<!-- Switch Current Team -->
@if (Spark::showsTeamSwitcher())
    <a class="tw-block hover:tw-text-white tw-text-gray-800 tw-px-4 tw-py-2 hover:tw-bg-indigo-500 hover:tw-no-underline" v-for="team in teams" :href="'/settings/{{ Spark::teamsPrefix() }}/'+ team.id +'/switch'">
        <span v-if="user.current_team_id == team.id">
            <i class="fa fa-fw fa-btn fa-check text-success tw-mr-2"></i> @{{ team.name }}
        </span>

        <span v-else>
            <img :src="team.photo_url" class="tw-rounded-full tw-h-4 tw-w-4" alt="{{__('Team Photo')}}" /><i class="fa fa-btn"></i> @{{ team.name }}
        </span>
    </a>
@endif

<div class="tw-my-2 tw-border-t-1"></div>
