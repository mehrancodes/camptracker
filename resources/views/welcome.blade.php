@extends('layouts.guest')

@section('content')
    <!-- Hero Section -->
    <div class="tw-container tw-mx-auto">
        <div class="tw-flex tw-justify-center">
            <div class="tw-px-6 md:tw-max-w-5xl">
                <h1 class="tw-text-5xl lg:tw-text-7xl md:tw-text-center tw-font-black tw-leading-tight tw-text-gray-900">
                    Easy & affordable time tracking for Basecamp
                </h1>

                <div class="md:tw-px-20 tw-mt-3 tw-text-xl md:tw-text-2xl tw-leading-snug">
                    <span class="tw-font-bold">Connect</span> your Basecamp to Camp Tracker and tell your developers to add the time they spend on each todo and we will automatically track their time. Easy!
                </div>

                <div class="tw-flex tw-justify-center tw-mt-10">
                    <div class="md:tw-w-1/2">
                        <a
                            class="tw-block tw-px-4 tw-py-3 tw-bg-indigo-700 tw-text-white tw-text-center tw-font-bold tw-text-2xl tw-transition-100 tw-transition-linear tw-transition-bg hover:tw-bg-indigo-600"
                            href="/register"
                        >
                            Give Camp Tracker a Try
                        </a>
                        <p class="tw-mt-2 tw-text-sm md:tw-text-xl md:tw-tracking-wide tw-text-center">Start your 30 day trial with no credit card required!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Introduce section -->
    <svg class="tw-mt-40 md:tw-mt-16 lg:tw-mt-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#EBF4FF" fill-opacity="1" d="M0,288L20,277.3C40,267,80,245,120,208C160,171,200,117,240,106.7C280,96,320,128,360,144C400,160,440,160,480,176C520,192,560,224,600,202.7C640,181,680,107,720,101.3C760,96,800,160,840,181.3C880,203,920,181,960,154.7C1000,128,1040,96,1080,112C1120,128,1160,192,1200,192C1240,192,1280,128,1320,112C1360,96,1400,128,1420,144L1440,160L1440,320L1420,320C1400,320,1360,320,1320,320C1280,320,1240,320,1200,320C1160,320,1120,320,1080,320C1040,320,1000,320,960,320C920,320,880,320,840,320C800,320,760,320,720,320C680,320,640,320,600,320C560,320,520,320,480,320C440,320,400,320,360,320C320,320,280,320,240,320C200,320,160,320,120,320C80,320,40,320,20,320L0,320Z"></path></svg>
    <div class="tw-flex tw-justify-center tw-px-6 tw-bg-indigo-100">
        <div class="tw-max-w-6xl">
            <img
                class="tw--mt-48 tw-border tw-rounded-lg tw-shadow-xl"
                src="/img/todos_page.png"
                alt="Introduction Image">

            <br/>

            <div class="tw-mt-8 md:tw-text-center">
                <h2 class="tw-text-5xl md:tw-text-6xl tw-font-black tw-leading-tight tw-text-gray-900">Stop paying crazy amounts of money to track your teams time!</h2>

                <div class="md:tw-px-16 tw-mt-3 tw-leading-tight tw-text-xl md:tw-text-2xl">
                    <p>
                        We don't know about you but we think it's crazy to pay tons of money to track the time of our team.  Time tracking should be simple and affordable don't you agree?
                    </p>

                    <p class="tw-mt-6">
                        With Camp Tracker, you see what everyone is working on in your Basecamp projects and how much time they have spent and you only pay <span class="tw-font-bold"><u>one price, no matter how big your team is!</u></span>  Simple and affordable, thats our motto!
                    </p>

                    <p class="tw-mt-6">
                        <h2 class="tw-text-5xl md:tw-text-6xl tw-font-black tw-leading-tight tw-text-gray-900">How does it work?</h2>
                        <br/>
                        <ol>
                        <li>1. Connect your Basecamp account to Camp Tracker.</li>
                        <li>2. Add the projects you want to track time for.</li>
                        <li>3. When your team wants to track time for a specific TODO they add their time by posting the following comment to the TODO:
                        <br/><br/>
                        <strong>#HOURS=hh:mm<br/>
                        #NOTE="optional note about what was done"<br/>
                        </strong><br/>
                        </li>
                        <li>4. Go to CampTracker.com any time to view time reports for your entire team.
                        </ol>
                    </p>


                </div>

                <!--
                <a class="tw-block tw-mt-8 tw-underline tw-font-black tw-text-lg md:tw-text-xl" href="#">
                    Camp Tracker is different – take a deeper look at how it works >
                </a>
                -->

            </div>
        </div>
    </div>
    <svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#EBF4FF" fill-opacity="1" d="M0,160L13.3,160C26.7,160,53,160,80,170.7C106.7,181,133,203,160,218.7C186.7,235,213,245,240,208C266.7,171,293,85,320,69.3C346.7,53,373,107,400,122.7C426.7,139,453,117,480,122.7C506.7,128,533,160,560,186.7C586.7,213,613,235,640,218.7C666.7,203,693,149,720,144C746.7,139,773,181,800,197.3C826.7,213,853,203,880,192C906.7,181,933,171,960,144C986.7,117,1013,75,1040,90.7C1066.7,107,1093,181,1120,224C1146.7,267,1173,277,1200,240C1226.7,203,1253,117,1280,117.3C1306.7,117,1333,203,1360,213.3C1386.7,224,1413,160,1427,128L1440,96L1440,0L1426.7,0C1413.3,0,1387,0,1360,0C1333.3,0,1307,0,1280,0C1253.3,0,1227,0,1200,0C1173.3,0,1147,0,1120,0C1093.3,0,1067,0,1040,0C1013.3,0,987,0,960,0C933.3,0,907,0,880,0C853.3,0,827,0,800,0C773.3,0,747,0,720,0C693.3,0,667,0,640,0C613.3,0,587,0,560,0C533.3,0,507,0,480,0C453.3,0,427,0,400,0C373.3,0,347,0,320,0C293.3,0,267,0,240,0C213.3,0,187,0,160,0C133.3,0,107,0,80,0C53.3,0,27,0,13,0L0,0Z"></path>
    </svg>

    @include('partials.pricing-table')
@endsection()
