<!-- Impersonation -->
@if (session('spark:impersonator'))
    <h6 class="tw-block tw-py-2 tw-px-6 tw-text-sm tw-text-gray-600">{{__('Impersonation')}}</h6>

    <!-- Stop Impersonating -->
    <a class="tw-block hover:tw-text-white tw-text-gray-800 tw-px-4 tw-py-2 hover:tw-bg-indigo-500" href="/spark/kiosk/users/stop-impersonating">
        <i class="fa fa-fw fa-btn fa-user-secret tw-mr-2"></i> {{__('Back To My Account')}}
    </a>

    <div class="tw-my-2 tw-border-t-1"></div>
@endif

<!-- Developer -->
@if (Spark::developer(Auth::user()->email))
    @include('spark::nav.developer')
@endif

<!-- Subscription Reminders -->
@include('spark::nav.subscriptions')

<!-- Settings -->
<h6 class="tw-block tw-py-2 tw-px-6 tw-text-sm tw-text-gray-600">{{__('Settings')}}</h6>

<!-- Your Settings -->
<a class="tw-block hover:tw-text-white tw-text-gray-800 tw-px-4 tw-py-2 hover:tw-bg-indigo-500 hover:tw-no-underline" href="/settings">
    <i class="fa fa-fw fa-btn fa-cog tw-mr-2"></i> {{__('Your Settings')}}
</a>

<div class="tw-my-2 tw-border-t-1"></div>

@if (Spark::usesTeams() && (Spark::createsAdditionalTeams() || Spark::showsTeamSwitcher()))
    <!-- Team Settings -->
    @include('spark::nav.teams')
@endif

@if (Spark::hasSupportAddress())
    <!-- Support -->
    @include('spark::nav.support')
@endif

<!-- Logout -->
<a class="tw-block hover:tw-text-white tw-text-gray-800 tw-px-4 tw-py-2 hover:tw-bg-indigo-500 hover:tw-no-underline" href="/logout">
    <i class="fa fa-fw fa-btn fa-sign-out tw-mr-2"></i> {{__('Logout')}}
</a>
