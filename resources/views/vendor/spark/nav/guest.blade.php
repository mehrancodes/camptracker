<main-navbar inline-template>
    <div class="tw-mb-8 tw-bg-white tw-shadow-sm">
        <div class="tw-container tw-mx-auto">
            <header class="sm:tw-flex sm:tw-items-center sm:tw-justify-between">
                <div class="tw-flex tw-justify-between tw-px-4 tw-py-1 xl:tw-w-72">
                    <!-- Branding Image -->
                    @include('spark::nav.brand')

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
                            <a class="tw-block mr-4 tw-text-gray-800 hover:tw-no-underline hover:tw-text-gray-800" href="/login">
                                {{__('Login')}}
                            </a>
                            <a class="tw-block tw-text-gray-800 hover:tw-no-underline hover:tw-text-gray-800" href="/register">
                                {{__('Register')}}
                            </a>
                        </div>
                    </div>
                </nav>
            </header>
        </div>
    </div>
</main-navbar>
