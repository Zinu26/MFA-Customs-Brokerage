<head>
    <link rel="icon" href="/images/logo_1.png" type="image/x-icon" />

    <title>MFA Customs Brokerage</title>

    @extends('layouts.inc.topbarNav')
    @include('layouts.inc.header')
    <style>
        html,
     body {
         box-sizing: border-box;
         margin: 0;
         overflow-x: hidden;
         top: 0;
         left: 0;

         background-image: url('/images/cover.jpg');
         background-size: cover;
         background-repeat: no-repeat;
         box-shadow: inset 0px 4px 4px rgba(0, 0, 0, 0.25);
     }

     .form-container {
         width: 1109px;
         position: absolute;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
     }

     .form-container h1 {
         left: 0;
         right: 0;
         margin: auto;
         display: grid;
         text-align: center;
         margin-top: -250px;

         font-family: 'Roboto Slab';
         font-style: normal;
         font-weight: 800;
         font-size: 5vw;
         line-height: 1.2;
         text-transform: uppercase;

         color: #FFFFFF;
     }

     .form-container h2 {
         display: grid;
         width: 929px;
         height: 63px;
         margin: auto;
         margin-bottom: 25px;

         font-family: 'Roboto Slab';
         font-style: normal;
         font-weight: 600;
         font-size: 3vw;
         line-height: 1.2;
         text-align: center;
         text-transform: lowercase;

         color: #FFFFFF;
     }

     button {
         display: grid;
         text-align: center;
         margin: auto;
         cursor: pointer;
         outline: none;
         border: 0;
         vertical-align: middle;
         text-decoration: none;
         font-family: inherit;
         font-size: 15px;
     }

     button.learn-more {
         position: absolute;
         bottom: 30%;
         left: 45%;
         font-weight: 600;
         color: #382b22;
         text-transform: uppercase;
         padding: 1.25em 2em;
         background: #fff0f0;
         border: 2px solid #16700E;
         border-radius: 0.75em;
         -webkit-transform-style: preserve-3d;
         transform-style: preserve-3d;
         -webkit-transition: background 150ms cubic-bezier(0, 0, 0.58, 1), -webkit-transform 150ms cubic-bezier(0, 0, 0.58, 1);
         transition: transform 150ms cubic-bezier(0, 0, 0.58, 1), background 150ms cubic-bezier(0, 0, 0.58, 1), -webkit-transform 150ms cubic-bezier(0, 0, 0.58, 1);
     }

     button.learn-more::before {
         position: absolute;
         content: '';
         width: 100%;
         height: 100%;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background: #16700E;
         border-radius: inherit;
         -webkit-box-shadow: 0 0 0 2px #DCF0D5, 0 0.625em 0 0 #DCF0D5;
         box-shadow: 0 0 0 2px #DCF0D5, 0 0.625em 0 0 #DCF0D5;
         -webkit-transform: translate3d(0, 0.75em, -1em);
         transform: translate3d(0, 0.75em, -1em);
         transition: transform 150ms cubic-bezier(0, 0, 0.58, 1), box-shadow 150ms cubic-bezier(0, 0, 0.58, 1), -webkit-transform 150ms cubic-bezier(0, 0, 0.58, 1), -webkit-box-shadow 150ms cubic-bezier(0, 0, 0.58, 1);
     }

     button.learn-more:hover {
         background: #DCF0D5;
         -webkit-transform: translate(0, 0.25em);
         transform: translate(0, 0.25em);
     }

     button.learn-more:hover::before {
         -webkit-box-shadow: 0 0 0 2px #DCF0D5, 0 0.5em 0 0 #DCF0D5;
         box-shadow: 0 0 0 2px #DCF0D5, 0 0.5em 0 0 #DCF0D5;
         -webkit-transform: translate3d(0, 0.5em, -1em);
         transform: translate3d(0, 0.5em, -1em);
     }

     button.learn-more:active {
         background: #DCF0D5;
         -webkit-transform: translate(0em, 0.75em);
         transform: translate(0em, 0.75em);
     }

     button.learn-more:active::before {
         -webkit-box-shadow: 0 0 0 2px #DCF0D5, 0 0 #DCF0D5;
         box-shadow: 0 0 0 2px #DCF0D5, 0 0 #DCF0D5;
         -webkit-transform: translate3d(0, 0, -1em);
         transform: translate3d(0, 0, -1em);
     }

     /* Media queries */
     @media only screen and (max-width: 1080px) {

         .form-container {
         width: 100%;
         top: 50%;
         transform: translate(-50%, -50%);
         text-align: center;
         }

         .form-container h1 {
         font-size: 10vw;
         margin-top: -150px;
         }

         .form-container h2 {
         width: 100%;
         font-size: 5vw;
         margin-bottom: 15px;
         }

         button.learn-more {
         bottom: 30px;
         left: 50%;
         font-size: 12px;
         padding: 0.75em 1.5em;
         border-radius: 0.5em;
         }
     }

     </style>
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
