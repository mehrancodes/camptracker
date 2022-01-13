@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-2">
        <!-- Terms of Service -->
        <div class="tw-flex tw-justify-center tw--mx-2">
            <div class="tw-w-full md:tw-w-2/3 lg:tw-w-4/6 tw-px-2">
                <div class="tw-py-5 tw-px-3 tw-text-4xl tw-font-semibold">The CAMP TRACKER Privacy Policy was updated on December 12, 2019.</div>

                <div class="tw-p-5 markdown">
                    {!! $privacy !!}
                </div>
            </div>
        </div>
    </div>
@endsection
