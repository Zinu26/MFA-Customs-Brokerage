<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal{{$client->id}}"><i class="fa fa-pencil"></i></button>

<!--View modal-->
<div class="modal fade" style="color: black;" id="editModal{{$client->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
      </div>
      <form action="{{route('update_client', $client->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <input type="hidden" name="id" value="{{$client->id}}"/>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Name of Consignee</span>
                <input type="text" value="{{$client->name}}" name="name" placeholder="Name" aria-label="Name" class="form-control" required>
            </div></br>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">TIN Number</span>
                <input type="text" value="{{$client->tin}}" name="tin" placeholder="TIN Number" aria-label="TIN Number" class="form-control" required>
            </div></br>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Contact Number</span>
                <input type="text" value="{{$client->contact}}" name="contact" placeholder="Contact Number" aria-label="Contact Number" class="form-control" required>
            </div></br>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Email</span>
                <input type="text" value="{{$client->email}}" name="email" placeholder="Email" aria-label="Email" class="form-control" required>
            </div></br>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Address</span>
                <input type="text" value="{{$client->address}}" name="address" placeholder="Address" aria-label="Address" class="form-control" required>
            </div></br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="update_client" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
