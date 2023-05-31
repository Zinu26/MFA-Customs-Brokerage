<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#archiveModal{{ $user->id }}"><i
        class="fas fa-box-archive"></i></button>

<!--Archive modal-->
<div class="modal fade" id="archiveModal{{ $user->id }}" data-bs-backdrop="static" style="color: black;"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: rgb(202, 26, 26)">
                <h5 class="modal-title">ARCHIVE ADMIN</h5>
                <a style="cursor: pointer;" data-bs-dismiss="modal"><i class="fa fa-xmark"></i></a>
            </div>
            <form action="{{ route('archive_user', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <h4>Are you sure you want to <span style="color:red">archived</span> this employee?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" name="archive" class="btn btn-danger">ARCHIVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
