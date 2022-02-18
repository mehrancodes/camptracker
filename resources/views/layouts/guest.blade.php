<!doctype html>
<html lang="en">
<head>
    @include('analytics')

    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/tailwind.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
</head>
<body class="tw-h-screen tw-antialiased">
    <div>
        <!-- Navigation -->
        <div class="tw-relative tw-px-5 tw-pb-12 lg:tw-pb-20 tw-max-w-xl tw-mx-auto md:tw-max-w-2xl lg:tw-max-w-5xl">
            <div class="tw-relative">
                <div class="tw-flex tw-items-center tw-justify-between tw-py-3">
                    <a href="/" class="tw-flex tw-items-center">
                        <img src="img/camp-tracker-logo-transparent.png" style="width:45px">
                        <span class="tw-ml-2 tw-text-lg tw-text-gray-900"><strong>Camp Tracker</strong></span>
                    </a>

                    <div class="tw-flex">
                        <a class="tw-flex tw-items-center tw-border-2 tw-border-gray-800 tw-py-2 tw-px-5 tw-font-black tw-text-lg hover:tw-border-indigo-400 tw-transition-100 tw-transition-linear tw-transition-border" href="/login">
                            Sign In
                        </a>
                        <a class="sm:tw-items-center tw-hidden sm:tw-flex tw-ml-2 tw-py-2 tw-px-5 tw-font-black tw-text-lg tw-bg-gray-900 tw-text-white hover:tw-text-indigo-400 tw-transition-100 tw-transition-linear tw-transition-color" href="/register">
                            Try it Free
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <main class="tw-pb-10">
            @yield('content')
        </main>

        <div class="tw-container tw-mx-auto tw-mt-12 tw-px-6">
            <!-- Terms -->
            <ul>
                <li>
                    <span class="tw-font-bold">Keep in touch:</span>
                    <a class="tw-underline" href="mailto:support@camptracker.com">Email</a>,
                    <a class="tw-underline" href="https://twitter.com/getcamptracker">Twitter</a>
                </li>
                <li>
                    <span class="tw-font-bold">Legal:</span>
                    <a class="tw-underline" href="/privacy">Privacy</a>,
                    <a class="tw-underline" href="/terms">Terms Of Service</a>
                </li>
                <!--
                <li>
                    <span class="tw-font-bold">Help:</span>
                    <a class="tw-underline" href="/how-it-works">How it Works?</a>
                </li>
                -->
                <li>
                    <span class="tw-font-bold">More:</span>
                    <a class="tw-underline" href="/pricing">Pricing</a>
                </li>
            </ul>

            <!-- Copyright -->
            <div class="tw-mt-4 tw-mb-20">
                Copyright ©2022 Camp Tracker. All rights reserved. <a href="mailto:support@camptraker.com"><u>Contact us</u></a>.
            </div>
        </div>
    </div>
</body>
</html>
