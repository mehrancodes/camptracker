<form role="form">
    @if (Spark::usesTeams() && Spark::onlyTeamPlans())
        <!-- Team Name -->
        <div class="md:tw-flex md:tw-items-center tw-mb-6" v-if=" ! invitation">
            <div class="md:tw-w-1/3">
                <label class="tw-block tw-text-gray-500 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-4" for="text">
                    {{ __('teams.team_name') }}
                </label>
            </div>
            <div class="md:tw-w-2/3">
                <input
                    v-model="registerForm.team"
                    :class="{'tw-border-red-500': registerForm.errors.has('team')}"
                    class="tw-form-input tw-block tw-w-full"
                    id="text"
                    type="text"
                    name="team"
                    autofocus
                >
            </div>
        </div>

        @if (Spark::teamsIdentifiedByPath())
            <!-- Team Slug (Only Shown When Using Paths For Teams) -->
            <div class="md:tw-flex md:tw-items-center tw-mb-6">
                <div class="md:tw-w-2/6">
                    <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="team_slug">
                        {{__('Name')}}
                    </label>
                </div>
                <div class="md:tw-w-3/6">
                    <input
                        v-model="registerForm.team_slug"
                        :class="{'tw-border-red-500': registerForm.errors.has('team_slug')}"
                        class="tw-form-input tw-block tw-w-full"
                        id="team_slug"
                        type="text"
                        name="team_slug"
                    >

                    <span class="tw-mt-1 tw-text-xs tw-text-gray-500" v-show="registerForm.errors.has('team_slug')">
                        @{{ registerForm.errors.get('team_slug') }}
                    </span>

                    <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('team_slug')">
                        @{{ registerForm.errors.get('team_slug') }}
                    </span>
                </div>
            </div>
        @endif
    @endif

    <!-- Name -->
    <div class="md:tw-flex md:tw-items-center tw-mb-6">
        <div class="md:tw-w-2/6">
            <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="name">
                {{__('Name')}}
            </label>
        </div>
        <div class="md:tw-w-3/6">
            <input
                v-model="registerForm.name"
                :class="{'tw-border-red-500': registerForm.errors.has('name')}"
                class="tw-form-input tw-block tw-w-full"
                id="name"
                type="text"
                name="name"
                autofocus
            >

            <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('name')">
                @{{ registerForm.errors.get('name') }}
            </span>
        </div>
    </div>

    <!-- E-Mail Address -->
    <div class="md:tw-flex md:tw-items-center tw-mb-6">
        <div class="md:tw-w-2/6">
            <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="email">
                {{__('E-Mail Address')}}
            </label>
        </div>
        <div class="md:tw-w-3/6">
            <input
                v-model="registerForm.email"
                :class="{'tw-border-red-500': registerForm.errors.has('email')}"
                class="tw-form-input tw-block tw-w-full"
                id="email"
                type="email"
                name="email"
            >

            <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('email')">
            @{{ registerForm.errors.get('email') }}
        </span>
        </div>
    </div>

    <!-- Password -->
    <div class="md:tw-flex md:tw-items-center tw-mb-6">
        <div class="md:tw-w-2/6">
            <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="password">
                {{__('Password')}}
            </label>
        </div>
        <div class="md:tw-w-3/6">
            <input
                v-model="registerForm.password"
                :class="{'tw-border-red-500': registerForm.errors.has('password')}"
                class="tw-form-input tw-block tw-w-full"
                id="password"
                type="password"
                name="password"
            >

            <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('password')">
                @{{ registerForm.errors.get('password') }}
            </span>
        </div>
    </div>

    <!-- Password Confirmation -->
    <div class="md:tw-flex md:tw-items-center tw-mb-6">
        <div class="md:tw-w-2/6">
            <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="password_confirmation">
                {{__('Confirm Password')}}
            </label>
        </div>
        <div class="md:tw-w-3/6">
            <input
                v-model="registerForm.password_confirmation"
                :class="{'tw-border-red-500': registerForm.errors.has('password_confirmation')}"
                class="tw-form-input tw-block tw-w-full"
                id="password_confirmation"
                type="password"
                name="password_confirmation"
            >

            <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('password_confirmation')">
                @{{ registerForm.errors.get('password_confirmation') }}
            </span>
        </div>
    </div>

    <!-- Terms And Conditions -->
    <div v-if=" ! selectedPlan || selectedPlan.price == 0">
        <div class="md:tw-flex md:tw-items-center tw-mb-4">
            <div class="md:tw-w-2/6"></div>
            <div class="md:tw-w-3/6">
                <label class="tw-flex tw-items-center">
                    <input type="checkbox" class="tw-form-checkbox" v-model="registerForm.terms">
                    <span class="tw-ml-2">
                        {!! __('I Accept :linkOpen The Terms Of Service :linkClose', ['linkOpen' => '<a href="/terms" target="_blank">', 'linkClose' => '</a>']) !!}
                    </span>
                </label>

                <span class="tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('terms')">
                    @{{ registerForm.errors.get('terms') }}
                </span>
            </div>
        </div>

        <div class="md:tw-flex md:tw-items-center">
            <div class="md:tw-w-2/6"></div>
            <div class="md:tw-w-3/6">
                <button
                    :disabled="registerForm.busy"
                    class="tw-btn tw-btn-primary"
                    @click.prevent="register"
                >
                    <span v-if="registerForm.busy">
                        <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Registering')}}
                    </span>

                    <span v-else>
                        <i class="fa fa-btn fa-check-circle"></i> {{__('Register')}}
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>
