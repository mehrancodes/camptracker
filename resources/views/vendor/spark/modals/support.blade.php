<!-- Customer Support -->
<div
    class="tw-fixed tw-px-2 tw-top-0 tw-z-1050 tw-hidden tw-w-full tw-h-full"
    id="modal-support"
    role="dialog"
>
    <div class="tw-w-full sm:tw-max-w-xs tw-mx-auto tw-mt-10">
        <div class="tw-bg-gray-100">
            <!-- Modal Body -->
            <div class="tw-p-4">
                <form role="form">
                    <!-- From -->
                    <div class="tw-mb-6">
                        <input
                            v-model="supportForm.from"
                            :class="{'tw-border-red-500': supportForm.errors.has('from')}"
                            class="tw-form-input tw-block tw-w-full"
                            id="support-from"
                            type="text"
                            name="email"
                            placeholder="{{__('Your Email Address')}}"
                        >

                        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="supportForm.errors.has('from')">
                            @{{ supportForm.errors.get('from') }}
                        </span>
                    </div>

                    <!-- Subject -->
                    <div class="tw-mb-6">
                        <input
                            v-model="supportForm.subject"
                            :class="{'tw-border-red-500': supportForm.errors.has('subject')}"
                            class="tw-form-input tw-block tw-w-full"
                            id="support-subject"
                            type="text"
                            name="text"
                            placeholder="{{__('Subject')}}"
                        >

                        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="supportForm.errors.has('subject')">
                            @{{ supportForm.errors.get('subject') }}
                        </span>
                    </div>

                    <!-- Message -->
                    <div class="tw-mb-6">
                        <textarea
                            v-model="supportForm.message"
                            :class="{'tw-border-red-500': supportForm.errors.has('message')}"
                            class="tw-form-textarea tw-block tw-w-full"
                            id="support-message"
                            name="text"
                            rows="7"
                            placeholder="{{__('Message')}}"
                        ></textarea>

                        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="supportForm.errors.has('message')">
                            @{{ supportForm.errors.get('message') }}
                        </span>
                    </div>
                </form>
            </div>

            <!-- Modal Actions -->
            <div class="tw-border-t tw-py-5 tw-px-4 tw-rounded-br-sm tw-rounded-bl-sm">
                <button class="tw-btn tw-btn-default" @click.prevent="sendSupportRequest" :disabled="supportForm.busy">
                    <i class="fa fa-btn fa-paper-plane"></i> {{__('Send')}}
                </button>
            </div>
        </div>
    </div>
</div>
