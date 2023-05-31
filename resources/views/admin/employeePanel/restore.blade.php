<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#unarchiveModal{{ $user->id }}"><i
        class="fas fa-arrow-up"></i></button>

<!--Restore modal-->
<div class="modal fade" id="unarchiveModal{{ $user->id }}" data-bs-backdrop="static" style="color: black;"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">RESTORE ADMIN</h5>
                <a style="cursor: pointer;" data-bs-dismiss="modal"><i class="fa fa-xmark"></i></a>
            </div>
            <form action="{{ route('restore_user', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <h4>Are you sure you want to <span style="color:green">restore</span> this employee?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" name="archive" class="btn btn-success">RESTORE</button>
                </div>
            </form>
        </div>
    </div>
</div>
