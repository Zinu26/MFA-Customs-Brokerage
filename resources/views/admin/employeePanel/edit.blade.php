<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal{{$user->id}}"><i class="fa fa-pencil"></i></button>

<!--Edit modal-->
<div class="modal fade" id="editModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: black;">Edit Profile</h1>
        </div>
        <form action="{{route('edit_employee', $user->id)}}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <input type="hidden" name="id" value="<{{$user->id}}" />
            <input type="hidden" name="user_id" value="{{$user->employee->user_id}}" />
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Full Name</span>
              <input type="text" value="{{$user->name}}" name="name" placeholder="Full Name" aria-label="Full Name" class="form-control">
            </div></br>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Position</span>
                <input type="text" value="{{$user->employee->position}}" name="position" placeholder="Position" aria-label="Position" class="form-control">
              </div></br>
              <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Birth date</span>
                <input type="date" value="{{$user->employee->birthdate}}" name="birthdate" placeholder="Birth date" aria-label="Birth date" class="form-control">
              </div></br>
              <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Contact Number</span>
                <input type="text" value="{{$user->employee->contact_number}}" name="contact" placeholder="Contact Number" aria-label="Contact Number" class="form-control">
              </div></br>
              <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Email</span>
                <input type="email" value="{{$user->email}}" name="email" placeholder="Email" aria-label="Email" class="form-control">
              </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Username</span>
              <input type="text" value="{{$user->username}}" name="username" placeholder="Username" aria-label="Username" class="form-control">
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Password</span>
              <div class="input-group-prepend">
                <input type="password" value="{{$user->password}}" name="password" placeholder="Password" aria-label="Password" class="form-control" id="password">
                <span class="input-group-text" id="togglePassword">
                  <i class="fa fa-eye-slash"></i>
                </span>
              </div>
            </div></br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="update" class="btn btn-success">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye / eye slash icon
      this.querySelector('i').classList.toggle('fa-eye');
      this.querySelector('i').classList.toggle('fa-eye-slash');
    });
  </script>
