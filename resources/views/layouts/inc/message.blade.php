<style>
    .notification {
        position: fixed;
        top: 20px;
        left: 120px;
        /* changed from "right" */
        padding: 10px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        opacity: 1;
        z-index: 99999;
        transition: opacity 0.5s ease-in-out;
    }

    .notification.success {
        background-color: #5cb85c;
        /* green */
        color: #fff;
    }

    .notification.error {
        background-color: #d9534f;
        /* red */
        color: #fff;
    }

    .notification.warning {
        background-color: #f0ad4e;
        /* yellow */
        color: #fff;
    }

    .notification.hide {
        opacity: 0;
    }
</style>

@if (session()->has('success'))
    <div class="notification success" id="notification">
        <i class="fa-sharp fa-solid fa-circle-check"></i> {{ session()->get('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="notification error" id="notification">
        <i class="fa-sharp fa-solid fa-circle-exclamation"></i> {{ session()->get('error') }}
    </div>
@endif

@if (session()->has('warning'))
    <div class="notification warning" id="notification">
        <i class="fa-sharp fa-solid fa-triangle-exclamation"></i> {{ session()->get('warning') }}
    </div>
@endif

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#notification').addClass('hide');
            setTimeout(function() {
                $('#notification').remove();
            }, 500);
        }, 3000);
    });
</script>
