<div
    class="tw-fixed tw-px-2 tw-top-0 tw-z-1050 tw-hidden tw-w-full tw-h-full"
    id="modal-plan-details"
    role="dialog"
>
    <div class="tw-w-full sm:tw-max-w-xs tw-mt-10">
        <div class="tw-bg-gray-100" v-if="detailingPlan">
            <!-- Modal Header -->
            <div class="tw-bg-white tw-py-5 tw-px-4 tw-border-b tw-rounded-tr-sm tw-rounded-tl-sm">
                <h5 class="tw-font-light">
                    @{{ detailingPlan.name }}
                </h5>
            </div>

            <!-- Modal Body -->
            <div class="tw-p-4">
                <ul class="tw-list-none tw-p-0 tw-m-0 tw-leading-loose">
                    <li v-for="feature in detailingPlan.features">
                        @{{ feature }}
                    </li>
                </ul>
            </div>

            <!-- Modal Actions -->
            <div class="tw-border-t tw-py-5 tw-px-4 tw-rounded-br-sm tw-rounded-bl-sm">
                <button
                    class="tw-btn tw-btn-default"
                    data-dismiss="modal"
                    type="button"
                >
                    {{__('Close')}}
                </button>
            </div>
        </div>
    </div>
</div>
