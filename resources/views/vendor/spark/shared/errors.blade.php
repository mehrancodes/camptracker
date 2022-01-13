@if (count($errors) > 0)
    <div class="tw-my-6 tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-rounded tw-relative" role="alert">
        <strong>{{__('Whoops!')}}</strong> {{__('Something went wrong!')}}

        <ul class="tw-mt-5 tw-list-disc tw-list-inside tw-leading-snug">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
