<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MFA Customs Brokerage</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @extends('layouts.inc.topbarNav')
    @extends('layouts.inc.header')
    <link rel="stylesheet" href="/css/welcome.css" />
</head>

<body class="antialiased">
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <section>
            <div class="form-container">
                <h1>Offers Highest Quality of Service</h1>
                <h2>20 years in the business</h2>
            </div>
        </section>
    </div>

    @include ('chatbot.chatbot')
</body>

</html>


<script>
    const sidebarOpen = document.querySelector('.sidebarOpen');
    const sidebarClose = document.querySelector('.sidebarClose');
    const menu = document.querySelector('.menu');

    sidebarOpen.addEventListener('click', () => {
        menu.classList.add('show');
    });

    sidebarClose.addEventListener('click', () => {
        menu.classList.remove('show');
    });
</script>
