@include('layouts.inc.header')
@include('layouts.inc.topbarNav')
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" href="/css/contact.css">
<title>MFA Customs Brokerage</title>

<div class="background">
    <div class="container">
        <div class="screen">
            <div class="screen-header">
                <div class="screen-header-left">
                    <div class="screen-header-button close"></div>
                    <div class="screen-header-button maximize"></div>
                    <div class="screen-header-button minimize"></div>
                </div>
                <div class="screen-header-right">
                    <div class="screen-header-ellipsis"></div>
                    <div class="screen-header-ellipsis"></div>
                    <div class="screen-header-ellipsis"></div>
                </div>
            </div>
            <div class="screen-body">
                <div class="screen-body-item left">
                    <div class="app-title">
                        <span>Get In Touch with Us</span>
                    </div>
                    <div class="app-contact">Address : Rm. 450 4/F Padilla Delos Reyes Bldg. 232 Juan Luna St., Binondo,
                        Manila</div>
                    <div class="app-contact">CONTACT INFO : +82 887 706</div>
                    <div class="app-contact"><iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.0226367189885!2d120.97308531484012!3d14.597785989804198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca0e6a3284fb%3A0x12764225cff73e4a!2sPadilla%20-%20De%20Los%20Reyes%20Bldg.!5e0!3m2!1sen!2sph!4v1679393234249!5m2!1sen!2sph"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe></div>
                </div>
                <div class="screen-body-item">
                    <form method="POST" action="{{ route('sendFeedback') }}">
                        @csrf
                        <div class="app-form">
                            <div class="app-form-group">
                                <input type="text" class="app-form-control" name="name" placeholder="NAME">
                            </div>
                            <div class="app-form-group">
                                <input type="email" class="app-form-control" name="email" placeholder="EMAIL">
                            </div>
                            <div class="app-form-group">
                                <input type="number" class="app-form-control" name="contact" placeholder="CONTACT NO">
                            </div>
                            <div class="app-form-group message">
                                <textarea  name="message" class="app-form-control" placeholder="MESSAGE"></textarea>
                            </div>
                            <div class="app-form-group buttons">
                                <button type="submit" class="app-form-button">SEND</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function addClass() {
        document.body.classList.add("sent");
    }

    sendLetter.addEventListener("click", addClass);
</script>
