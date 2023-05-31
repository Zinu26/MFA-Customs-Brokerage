<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $user->id }}"><i
        class="fas fa-eye"></i></button>

<!--Edit modal-->
<div class="modal fade" id="viewModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">VIEW EMPLOYEE</h5>
                <a style="cursor: pointer;" data-bs-dismiss="modal"><i class="fa fa-xmark"></i></a>
            </div>
            <fieldset disabled>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<{{ $user->id }}" />
                    <input type="hidden" name="user_id" value="{{ $user->employee->user_id }}" />
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Full Name</span>
                        <input type="text" value="{{ $user->name }}" name="name" placeholder="Full Name"
                            aria-label="Full Name" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Position</span>
                        <input type="text" value="{{ $user->employee->position }}" name="position"
                            placeholder="Position" aria-label="Position" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Birthdate</span>
                        <input type="date" value="{{ $user->employee->birthdate }}" name="birthdate"
                            placeholder="Birth date" aria-label="Birth date" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Contact</span>
                        <input type="text" value="{{ $user->employee->contact_number }}" name="contact"
                            placeholder="Contact Number" aria-label="Contact Number" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Email</span>
                        <input type="email" value="{{ $user->email }}" name="email" placeholder="Email"
                            aria-label="Email" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Username</span>
                        <input type="text" value="{{ $user->username }}" name="username" placeholder="Username"
                            aria-label="Username" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Date Added</span>
                        <input value="{{ date('Y-m-d h:i A', strtotime($user->employee->created_at)) }}"
                            placeholder="Date Added" aria-label="Date Added" class="form-control">
                    </div></br>
                    @if ($user->isArchived == false)
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Date Updated</span>
                            <input value="{{ date('Y-m-d h:i A', strtotime($user->employee->updated_at)) }}"
                                placeholder="Date Updated" aria-label="Date Updated" class="form-control">
                        </div></br>
                    @elseif($user->isArchived == true)
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Date Archived</span>
                            <input value="{{ date('Y-m-d h:i A', strtotime($user->employee->updated_at)) }}"
                                placeholder="Date Updated" aria-label="Date Updated" class="form-control">
                        </div></br>
                    @endif
                </div>
            </fieldset>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
