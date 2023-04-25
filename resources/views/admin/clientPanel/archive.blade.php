<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#archiveModal{{$client->id}}"><i class="fa fa-trash"></i></button>

<!--Hide modal-->
<div class="modal fade" id="archiveModal{{$client->id}}" data-bs-backdrop="static" style="color: black;" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Archive Data</h1>
      </div>
      <form action="{{route('archive_client', $client->id)}}" method="POST">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="id" value="{{$client->id}}">
            <h4>Do you want to archive this data?</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="archive" class="btn btn-danger">Archive</button>
        </div>
       </form>
    </div>
  </div>
</div>
