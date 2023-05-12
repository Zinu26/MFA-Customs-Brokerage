<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $user->id }}"><i
        class="fa fa-eye"></i></button>

<!--View modal-->
<div class="modal fade" id="viewModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: black;">View Profile</h1>
            </div>
            <fieldset disabled>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<{{ $user->id }}" />
                    <input type="hidden" name="type" value="{{ $user->type }}" />
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Full Name</span>
                        <input type="text" value="{{ $user->name }}" name="name" placeholder="Full Name"
                            aria-label="Full Name" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Username</span>
                        <input type="text" value="{{ $user->username }}" name="username" placeholder="Username"
                            aria-label="Username" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Password</span>
                        <div class="input-group-prepend">
                            <input type="password" value="{{ $user->password }}" name="password" placeholder="Password"
                                aria-label="Password" class="form-control" id="password">
                            <span class="input-group-text" id="togglePassword">
                                <i class="fa fa-eye-slash"></i>
                            </span>
                        </div>
                    </div></br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye / eye slash icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>
