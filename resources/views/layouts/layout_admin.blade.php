<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') - {{ config('app.name') }}</title>
    <base href="{{asset('')}}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/img/favicons/favicon-16x16.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/tailwind.output.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/tooltip.css') }}">

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/brands.min.css"
        integrity="sha512-OivR4OdSsE1onDm/i3J3Hpsm5GmOVvr9r49K3jJ0dnsxVzZgaOJ5MfxEAxCyGrzWozL9uJGKz6un3A7L+redIQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css"
        integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
</head>

<body>
    <noscript>Vui lòng bật Javascript của trình duyệt</noscript>
    <div id="app" class="flex h-screen bg-gray-50 dark:bg-gray-900" user="{{ auth()->user()->id ?? 0 }}"
        :class="{ 'overflow-hidden': isSideMenuOpen }">

        <!-- Loading -->
        <transition enter-class="opacity-100" enter-to-class="opaccity-100" leave-class="transition ease-in"
            leave-to-class="opacity-0">
            <div v-if="this.isLoad"
                class="fixed z-[100] duration-150 h-full w-full bg-[#ffffff] flex items-center justify-center flex-col">
                <img src="{{ asset('/img/lyunhouse.jpg') }}" class="h-48" alt="Loading" loading="lazy">
                <span class="text-sm my-2">
                    {{ __('Đang tải...') }}
                </span>
            </div>
        </transition>

        <!-- Desktop sidebar -->
        @include('layouts.navigate')
        <div class="flex flex-col flex-1 w-full">
            <header class="z-10 py-2 bg-[#ffffff] shadow-md dark:bg-gray-800">
                @include('layouts.header')
            </header>
            <main class="h-full overflow-y-auto">             
                @yield('main')
            </main>
        </div>
        <transition enter-class="opacity-0" enter-to-class="opacity-100" leave-to-class="opacity-0">
            <profile v-if="isModalProfile" class="z-50 transition ease-in-out duration-150"
                :user="{{ auth()->user()->load(['role']) }}" @toggle-profile="toggleProfileModal"></profile>
        </transition>
        [[ setSelectedMenu({{ $current }}) ]]
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('script')

</body>

</html>