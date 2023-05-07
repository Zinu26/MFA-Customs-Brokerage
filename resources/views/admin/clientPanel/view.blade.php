<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{$client->id}}"><i class="fa fa-eye"></i></button>

<!--View modal-->
<div class="modal fade" style="color: black;" id="viewModal{{$client->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">View Consignee</h1>
      </div>
      <fieldset disabled>
        <div class="modal-body">
            <input type="hidden" name="id" value="{{$client->id}}"/>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Name of Consignee</span>
                <input type="text" value="{{$client->user->name}}" name="name" placeholder="Name" aria-label="Name" class="form-control" required>
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
                <input type="text" value="{{$client->user->email}}" name="email" placeholder="Email" aria-label="Email" class="form-control" required>
            </div></br>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Address</span>
                <input type="text" value="{{$client->address}}" name="address" placeholder="Address" aria-label="Address" class="form-control" required>
            </div></br>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Date Added</span>
                <input value="{{$client->created_at}}" name="Date Added" placeholder="Date Added" aria-label="Date Added" class="form-control" required>
            </div></br>
            <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Date Updated</span>
                <input value="{{$client->updated_at}}" name="Date Updated" placeholder="Date Updated" aria-label="Date Updated" class="form-control" required>
            </div></br>
        </div>
    </fieldset>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
