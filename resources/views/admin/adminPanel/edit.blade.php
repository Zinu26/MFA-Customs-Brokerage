<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}"><i
        class="fa fa-pencil"></i></button>

<!--Edit modal-->
<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: black;">Edit Profile</h1>
            </div>
            <form action="{{ route('edit_admin', $user->id) }}" method="POST">
                @csrf
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
                            style="background-color: #4EA646; font-weight: 600; color: white;">Email</span>
                        <input type="text" name="email" placeholder="{{ $user->email }}" aria-label="Email"
                            class="form-control" required>
                    </div></br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
