<!-- NavBar For Authenticated Users -->
<main-navbar
    :user="user"
    :teams="teams"
    :current-team="currentTeam"
    :unread-announcements-count="unreadAnnouncementsCount"
    :unread-notifications-count="unreadNotificationsCount"
    inline-template>

    <div class="tw-mb-8 tw-bg-white tw-shadow-sm">
        <div class="tw-container tw-mx-auto">
            <header class="sm:tw-flex sm:tw-items-center sm:tw-justify-between" v-if="user">
                <div class="tw-flex tw-justify-between tw-px-4 tw-py-1 xl:tw-w-72">
                    <!-- Branding Image -->
                    @include('spark::nav.logged-in-brand')
                    <ul class="tw-hidden sm:tw-flex tw-list-none tw-items-center">
                        @includeIf('spark::nav.user-left')
                    </ul>

                    <div class="tw-flex sm:tw-hidden">
                        <button class="tw-px-2 hover:tw-text-white focus:tw-outline-none focus:tw-text-white" @click="toggleIt">
                            <svg class="tw-h-6 tw-w-6 tw-fill-current tw-text-gray-500" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                <path v-if="navbarOpen" fill-rule="evenodd" clip-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"></path>
                                <path v-else="v-else" fill-rule="evenodd" clip-rule="evenodd" d="M3 6a1 1 0 0 1 1-1h16a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm0 6a1 1 0 0 1 1-1h16a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm1 5a1 1 0 1 0 0 2h16a1 1 0 1 0 0-2H4z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <nav :class="{ 'tw-hidden': !navbarOpen, 'tw-block': navbarOpen }" class="sm:tw-flex sm:tw-items-center sm:tw-px-4">
                    <div class="sm:tw-block sm:tw-flex sm:tw-items-center">
                        <div class="tw-px-2 tw-pt-2 tw-pb-5 tw-border-b tw-border-gray-800 sm:tw-flex sm:tw-border-b-0 sm:tw-py-0 sm:tw-px-0">
                            <a @click="showNotifications" class="tw-flex tw-cursor-pointer tw-items-center tw-justify-center tw-border tw-rounded-r-full tw-rounded-l-full tw-w-16 tw-h-8 tw-bg-gray-200 tw-text-gray-900 tw-font-bold tw-text-sm tw-mx-auto hover:tw-no-underline">
                                <svg class="tw-mr-2" width="18px" height="20px" viewBox="0 0 18 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs>
                                        <linearGradient x1="50%" y1="100%" x2="50%" y2="0%" id="linearGradient-1">
                                            <stop stop-color="#86A0A6" offset="0%"></stop>
                                            <stop stop-color="#596A79" offset="100%"></stop>
                                        </linearGradient>
                                    </defs>
                                    <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="header" transform="translate(-926.000000, -29.000000)" fill-rule="nonzero" fill="url(#linearGradient-1)">
                                            <g id="Group-3">
                                                <path d="M929,37 C929,34.3773361 930.682712,32.1476907 933.027397,31.3318031 C933.009377,31.2238826 933,31.1130364 933,31 C933,29.8954305 933.895431,29 935,29 C936.104569,29 937,29.8954305 937,31 C937,31.1130364 936.990623,31.2238826 936.972603,31.3318031 C939.317288,32.1476907 941,34.3773361 941,37 L941,43 L944,45 L944,46 L926,46 L926,45 L929,43 L929,37 Z M937,47 C937,48.1045695 936.104569,49 935,49 C933.895431,49 933,48.1045695 933,47 L937,47 L937,47 Z" id="Combined-Shape"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                @{{notificationsCount}}
                            </a>
                        </div>
                        <div class="tw-relative tw-px-5 tw-py-5 sm:tw-py-0 sm:tw-ml-4 sm:tw-px-0">
                            <div class="tw-flex tw-items-center sm:tw-hidden">
                                <img class="tw-w-12 tw-w-12 tw-object-cover tw-rounded-full tw-border-2 tw-border-gray-600" :src='user.photo_url' alt="{{__('User Photo')}}">
                                <span class="tw-ml-4 tw-font-semibold tw-text-gray-600 sm:tw-hidden">@{{ user.name }}</span>
                            </div>

                            <ul class="sm:tw-hidden tw-mt-5 tw-list-none tw-items-center">
                                @includeIf('spark::nav.user-left')
                            </ul>
                            <div class="tw-mt-5 sm:tw-hidden">
                                @include('vendor.spark.nav.links')
                            </div>
                            <dropdown class="tw-hidden sm:tw-block">
                                <template #trigger="{ hasFocus, isOpen }">
                                    <span
                                        class="tw-block tw-w-12 tw-w-12 tw-overflow-hidden tw-rounded-full tw-border-2 "
                                        :class="[(hasFocus || isOpen) ? 'tw-border-white xl:tw-border-indigo-500' : 'tw-border-gray-600 xl:tw-border-gray-300']"
                                    >
                                        <img class="tw-h-full tw-w-full tw-object-cover" :src='user.photo_url' alt="{{__('User Photo')}}">
                                    </span>
                                </template>
                                <template #dropdown>
                                    <div class="tw-mt-4 tw-bg-white xl:tw-border tw-rounded-lg tw-w-48 tw-py-2 tw-shadow-xl">
                                        @include('vendor.spark.nav.links')
                                    </div>
                                </template>
                            </dropdown>
                        </div>
                    </div>
                </nav>
            </header>
        </div>
    </div>
</main-navbar>
