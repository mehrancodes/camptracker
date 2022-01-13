@extends('layouts.guest')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-16 lg:tw-px-0">
        <div class="tw-flex tw-flex-wrap tw-justify-center">
            <div class="tw-w-full">
                <h1 class="tw-text-4xl lg:tw-text-5xl xl:tw-text-7xl lg:tw-text-center tw-font-black tw-leading-tight tw-text-gray-900 tw-tracking-tight">
                    Be your best <span class="tw-block lg:tw-inline">with CampTracker.</span>
                </h1>

                <div class="tw-flex tw-justify-center tw-mt-6">
                    <p class="tw-w-full lg:tw-max-w-2xl xl:tw-max-w-6xl lg:tw-text-center tw-text-lg lg:tw-text-xl">
                        Basecamp is more than just a project management tool — it’s an elevated way to work.
                        Companies that switch to Basecamp become better companies. They’re more productive and better organized.
                        They communicate better and require fewer meetings. And they’re far more efficient than before.
                        Being better is a choice <span class="tw-block md:tw-inline tw-font-medium">choose CampTracker.</span>
                    </p>
                </div>

                <h2 class="tw-mt-16 tw-text-3xl lg:tw-text-6xl md:tw-text-center tw-font-black tw-leading-tight tw-text-gray-800">
                    Here's how it works.
                </h2>
            </div>

            <div class='tw-mt-10 embed-container tw-w-full md:tw-w-9/12'>
                <iframe src='https://www.youtube.com/embed/6B4djWiJIlI' frameborder='0' allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <style>
        .embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
    </style>
@endsection
