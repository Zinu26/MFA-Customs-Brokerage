<head>
    <link rel="icon" href="/images/logo_1.png" type="image/x-icon" />

    <title>MFA Customs Brokerage</title>

    @extends('layouts.inc.topbarNav')
    @include('layouts.inc.header')
    <link rel="stylesheet" href="/css/welcome.css" />
</head>

        <section>
            <div class="form-container">
                <h1>Offers Highest Quality of Service</h1>
                <h2>20 years in the business</h2>
            </div>
        </section>

@include('chatbot.chatbot')

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
