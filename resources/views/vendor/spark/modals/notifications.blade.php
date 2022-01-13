<!-- Notifications Modal -->
<spark-notifications
    :notifications="notifications"
    :has-unread-announcements="hasUnreadAnnouncements"
    :loading-notifications="loadingNotifications" inline-template>

    <div>
        <div class="tw-hidden tw-fixed tw-h-full tw-left-0 tw-outline-none tw-top-0 tw-w-full tw-z-1050" id="modal-notifications" tabindex="-1" role="dialog">
            <div class="tw-m-0 tw-right-0 tw-top-0 tw-h-full tw-overflow-y-scroll tw-absolute" style="width: 350px;">
                <div class="tw-bg-gray-200 tw-fixed tw-h-full">
                    <div class="tw-flex tw-items-center tw-justify-center tw-bg-white tw-border-b-0 tw-fixed tw-h-20 tw-items-start tw-mb-0 tw-p-3 tw-text-center tw-z-50" style="width: 350px;">
                        <div class="tw-inline-flex">
                            <button
                                :class="{'active': showingNotifications}" @click="showNotifications"
                                class="tw-btn tw-btn-default tw-rounded-none tw-rounded-l tw-px-6"
                            >
                                {{__('Notifications')}}
                            </button>
                            <button
                                :class="{'active': showingAnnouncements}" @click="showAnnouncements"
                                class="tw-btn tw-btn-default tw-rounded-none tw-rounded-r tw-px-6"
                            >
                                {{__('Announcements')}} <i class="fa fa-circle tw-text-red-600" v-if="hasUnreadAnnouncements"></i>
                            </button>
                        </div>
                    </div>

                    <div class="tw-py-20 tw-h-screen tw-overflow-y-auto tw-relative">
                        <!-- Informational Messages -->
                        <div class="tw-mb-3 tw-px-4" v-if="loadingNotifications">
                            <div><i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Loading Notifications')}}</div>
                        </div>

                        <div class="tw-mb-3" v-if=" ! loadingNotifications && activeNotifications.length == 0">
                            <div class="tw-bg-orange-100 tw-border tw-text-yellow-800 tw-px-4 tw-py-3 tw-rounded tw-relative" role="alert">
                                {{__('We don\'t have anything to show you right now! But when we do, we\'ll be sure to let you know. Talk to you soon!')}}
                            </div>
                        </div>

                        <!-- List Of Notifications -->
                        <div class="tw-pb-4" v-if="showingNotifications && hasNotifications">
                            <div class="tw-mb-2 tw-pt-5 tw-px-4 tw-relative" v-for="(notification, notificationIndex) in notifications.notifications">
                                <div class="tw-pb-5 tw-border-t-1 tw-border-dashed tw-border-gray-600" v-if="notificationIndex > 0"></div>

                                <div class="tw-flex">
                                    <!-- Notification Icon -->
                                    <figure>
                                        <img v-if="notification.creator" :src="notification.creator.photo_url" class="tw-h-12 tw-rounded-full tw-w-12" alt="{{__('Creator Photo')}}" />

                                        <span v-else class="fa-stack fa-2x">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i :class="['fa', 'fa-stack-1x', 'fa-inverse', notification.icon]"></i>
                                    </span>
                                    </figure>

                                    <!-- Notification -->
                                    <div class="tw-pl-1 tw-pl-4">
                                        <div class="tw-content-end tw-flex">
                                            <p class="tw-flex-1 tw-font-bold tw-leading-tight tw-mb-2 tw-mt-1">
                                            <span v-if="notification.creator">
                                                @{{ notification.creator.name }}
                                            </span>

                                            <span v-else>
                                                {{ Spark::product() }}
                                            </span>
                                            </p>

                                            <div class="tw-text-gray-500">
                                                @{{ notification.created_at | relative }}
                                            </div>
                                        </div>

                                        <div class="tw-mb-4" v-html="notification.parsed_body"></div>

                                        <!-- Notification Action -->
                                        <a :href="notification.action_url" class="tw-btn tw-btn-primary" v-if="notification.action_text">
                                            @{{ notification.action_text }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- List Of Announcements -->
                        <div class="tw-pb-4" v-if="showingAnnouncements && hasAnnouncements">
                            <div class="tw-mb-2 tw-pt-5 tw-px-4 tw-relative" v-for="( announcement, AnnouncementIndex ) in notifications.announcements">
                                <div class="tw-pb-5 tw-border-t-1 tw-border-dashed tw-border-gray-300 tw-border-gray-400" v-if="AnnouncementIndex > 0"></div>

                                <div class="tw-flex">
                                    <!-- Notification Icon -->
                                    <figure>
                                        <img :src="announcement.creator.photo_url" class="tw-h-12 tw-rounded-full tw-w-12" alt="{{__('Creator Photo')}}" />
                                    </figure>

                                    <!-- Announcement -->
                                    <div class="tw-pl-1 tw-pl-4">
                                        <div class="tw-content-end tw-flex">
                                            <p class="tw-flex-1 tw-font-bold tw-leading-tight tw-mb-2 tw-mt-1">@{{ announcement.creator.name }}</p>

                                            <div class="tw-text-gray-500">
                                                @{{ announcement.created_at | relative }}
                                            </div>
                                        </div>

                                        <div class="tw-mb-4" v-html="announcement.parsed_body"></div>

                                        <!-- Announcement Action -->
                                        <a :href="announcement.action_url" class="tw-btn twbtn--primary" v-if="announcement.action_text">
                                            @{{ announcement.action_text }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="tw-bg-white tw-border-dashed tw-border-gray-100 tw-border-t-1 tw-bottom-0 tw-fixed tw-flex tw-h-20 tw-justify-end tw-p-5" style="width: 350px;">
                        <button type="button" class="tw-btn tw-btn-default" data-dismiss="modal">{{__('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-notifications>
