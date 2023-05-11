@include('layouts.inc.header')
@include('layouts.inc.topbarNav')
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" href="/css/contact.css">
<title>MFA Customs Brokerage</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/fontawesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<section class="contactUs">
    <div class="title">
        <h2>Get In Touch with Us</h2>
        <!--<p>Our goal at MFA Customs and Brokerage is to help you. Do you have inquiries for us? Or would you want to know more about our services? Our account managers take the time to discuss with you our services that can help you make smart decisions that best meet your needs.</p>-->
    </div>
    <div class="box">
        <div class="contact form">
            <h3>Send a Message</h3>
            <form method="POST" action="">
                @csrf
                <div class="formBox">
                    <div class="row50">
                        <div class="inputBox">
                            <span>Full Name</span>
                            <input type="text" name="name" placeholder="Full Name">
                        </div>
                    </div>
                    <div class="row50">
                        <div class="inputBox">
                            <span>Email</span>
                            <input type="text" name="email" placeholder="Email">
                        </div>
                        <div class="inputBox">
                            <span>Contact No.</span>
                            <input type="text" name="contact" placeholder="Contact">
                        </div>
                    </div>
                    <div class="row100">
                        <div class="inputBox">
                            <span>Message</span>
                            <textarea name="message" placeholder="Write your message here..."></textarea>
                        </div>
                    </div>
                    <div id="app">
                        <div id="message">Send</div>
                        <div id="send_btn"><i class="fas fa-plane"></i></div>
                    </div>
                </div>
            </form>
        </div>

        <div class="contact info">
            <h3>Contact Info</h3>
            <div class="infoBox">
                <div>
                    <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                    <p>Rm. 450 4/F Padilla Delos Reyes Bldg. 232 Juan Luna St., Binondo, Manila</p>
                </div>
                <div>
                    <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                    <p>+82887706</p>
                </div>
                <div>
                    <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <p>example@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="contact map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.0226367189885!2d120.97308531484012!3d14.597785989804198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca0e6a3284fb%3A0x12764225cff73e4a!2sPadilla%20-%20De%20Los%20Reyes%20Bldg.!5e0!3m2!1sen!2sph!4v1679393234249!5m2!1sen!2sph"
                style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>


<script>
    $(function(){
        $('#send_btn').on('click', function(){
            setTimeout(function(){
                $('#message').addClass('sending').text('Sending');
                $('#send_btn').addClass('sending');
            },0);

            setTimeout(function(){
                $('#message').addClass('sent').text('Sent');
                $('#send_btn').addClass('sent');
            },2600);
        })
    })
</script>
