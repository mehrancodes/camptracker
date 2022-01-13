<!-- Session Expired Modal -->
<div
    class="tw-fixed tw-px-2 tw-top-0 tw-z-1050 tw-hidden tw-w-full tw-h-full"
    id="modal-session-expired"
    role="dialog"
    data-backdrop="static"
    data-keyboard="false"
>
    <div class="tw-w-full sm:tw-max-w-xs tw-mx-auto tw-mt-10">
        <div class="tw-bg-gray-100">
            <!-- Modal Header -->
            <div class="tw-bg-white tw-py-5 tw-px-4 tw-border-b tw-rounded-tr-sm tw-rounded-tl-sm">
                <h5 class="tw-font-light">
                    {{__('Session Expired')}}
                </h5>
            </div>

            <!-- Modal Body -->
            <div class="tw-p-4">
                {{__('Your session has expired. Please login again to continue.')}}
            </div>

            <!-- Modal Actions -->
            <div class="tw-border-t tw-py-5 tw-px-4 tw-rounded-br-sm tw-rounded-bl-sm">
                <a
                    class="tw-btn tw-btn-default"
                    href="/login"
                >
                    <i class="fa fa-btn fa-sign-in"></i> {{__('Go To Login')}}
                </a>
            </div>
        </div>
    </div>
</div>
