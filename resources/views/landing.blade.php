<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MFA Customs Brokerage</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @include('layouts.inc.header')
        @include('layouts.inc.topbarNav')
        <link rel="stylesheet" href="/css/welcome.css"/>
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <section>
                <div class="form-container">
                    <h1>Offers Highest Quality of Service</h1>
                    <h2>20 years in the business</h2>
                </div>
                <div class="button-container">
                    <a href="{{route('about')}}" style="text-decoration: none;">
                        <button class="learn-more">Learn More About MFA</button>
                    </a>
                </div>
            </section>
        </div>

        @include ('bot')
    </body>
</html>

