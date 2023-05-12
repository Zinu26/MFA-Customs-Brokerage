<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#unarchiveModal{{ $client->id }}"><i
        class="fa fa-arrow-up"></i> Restore</button>

<!--Hide modal-->
<div class="modal fade" id="unarchiveModal{{ $client->id }}" data-bs-backdrop="static" style="color: black;"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Archive Data</h1>
            </div>
            <form
                action="@if (Auth::user()->type == 'admin') {{ route('restore_client', $client->id) }}@elseif(Auth::user()->type == 'employee'){{ route('restore_client.employee', $client->id) }} @endif"
                method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $client->id }}">
                    <h4>Do you want to restore this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="archive" class="btn btn-success">Restore</button>
                </div>
            </form>
        </div>
    </div>
</div>
