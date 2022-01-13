<template>
    <div>
        <div class="tw-px-3 tw-py-5 tw-mb-4 tw-fixed tw-right-2 tw-bottom-2 tw-border tw-border-t-8 tw-rounded tw-text-green-700 tw-border-green-600 tw-bg-green-100" role="alert" v-show="show && type === 'success'">
            <strong>Success!</strong> {{ body }}
        </div>

        <div class="tw-px-3 tw-py-5 tw-mb-4 tw-fixed tw-right-2 tw-bottom-2 tw-border tw-border-t-8 tw-rounded tw-text-red-700 tw-border-red-600 tw-bg-red-100" role="alert" v-show="show && type === 'error'">
            <strong>WHOOPS!</strong> {{ body }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        data: () => ({
            body: '',
            type: '',
            show: false
        }),
        mounted() {
            if (this.data) {
                this.flash(this.data)
            }
        },
        methods: {
            flash(data) {
                this.body = data.message;
                this.type = data.type;
                this.show = true;
                this.hide()
            },
            hide() {
                setTimeout(() => {
                    this.show = false
                }, 5000)
            }
        }
    }
</script>
