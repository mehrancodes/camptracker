<template>
    <div class="tw-relative">
        <button @click="toggle" type="button" class="tw-block focus:tw-outline-none" @focus="buttonHasFocus = true" @blur="buttonHasFocus = false">
            <slot name="trigger" :hasFocus="buttonHasFocus" :isOpen="isOpen"></slot>
        </button>
        <div :class="[isOpen ? 'wt-block' : 'tw-hidden']">
            <button @click="isOpen = false" type="button" class="tw-z-30 tw-block tw-fixed tw-inset-0 tw-w-full tw-h-full tw-cursor-default"></button>
            <div class="tw-absolute tw-z-40 tw-right-0">
                <slot name="dropdown"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                buttonHasFocus: false,
                isOpen: false,
            }
        },
        mounted() {
            const onEscape = (e) => {
                if (!this.isOpen || e.key !== 'Escape') {
                    return
                }
                this.isOpen = false
            }
            document.addEventListener('keydown', onEscape)

            this.$on('hook:destroyed', () => {
                document.removeEventListener('keydown', onEscape)
            })
        },
        methods: {
            toggle() {
                this.isOpen = !this.isOpen
            },
        },
    }
</script>
