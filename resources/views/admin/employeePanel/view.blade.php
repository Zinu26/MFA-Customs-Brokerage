<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{$user->id}}"><i class="fa fa-eye"></i></button>

<!--Edit modal-->
<div class="modal fade" id="viewModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: black;">View Profile</h1>
        </div>
        <fieldset disabled>
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
                <input type="email" value="{{$user->employee->email}}" name="email" placeholder="Email" aria-label="Email" class="form-control">
              </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Username</span>
              <input type="text" value="{{$user->username}}" name="username" placeholder="Username" aria-label="Username" class="form-control">
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Date Added</span>
              <input value="{{$user->employee->created_at}}" name="birthdate" placeholder="Date Added" aria-label="Date Added" class="form-control">
            </div></br>
            @if($user->isArchived == false)
                <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Date Updated</span>
                <input value="{{$user->employee->updated_at}}" name="birthdate" placeholder="Date Updated" aria-label="Date Updated" class="form-control">
                </div></br>
            @elseif($user->isArchived == true)
                <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Date Archived</span>
                <input value="{{$user->employee->updated_at}}" name="birthdate" placeholder="Date Updated" aria-label="Date Updated" class="form-control">
                </div></br>
            @endif
          </div>
        </fieldset>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
  </div>
