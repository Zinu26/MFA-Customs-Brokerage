<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-user-plus"></i> Add Shipment</button>

    <!--Add modal-->
    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Shipment</h1>
            </div>
            <form action="{{route('add_shipment')}}" method="POST">
            @csrf
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Consignee Name</span>
                        <input type="text" name="consignee_name" value="{{$consignee->name}}" placeholder="Consignee Name" aria-label="consignee_name" class="form-control" required readonly>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Item Description</span>
                        <input type="text" name="item_description" placeholder="Item Description" aria-label="item_description" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                    <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Size</span>
                    <input type="text" name="size" placeholder="Size" aria-label="Size" class="form-control" required>

                    <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Weight</span>
                    <input type="text" name="weight" placeholder="Weight" aria-label="Weight" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                    <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">BL Number</span>
                    <input type="text" name="BL_number" placeholder="BL Number" aria-label="BL Number" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                    <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Shipping Line</span>
                    <input type="text" name="shipping_line" placeholder="Shipping Line" aria-label="Shipping Line" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                    <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Arrival Time</span>
                    <input type="date" name="arrival_time" placeholder="Arrival Time" aria-label="Arrival Time" class="form-control" required>
                    </div></br>
                    <div class="row">
                    <div class="form-group col-md-3">
                        <label for="exampleFormControlSelect1">Shipment Status</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="shipment_status">
                        <option value="" disabled selected>---Select---</option>
                        <option value="AG">AG</option>
                        <option value="AS">AS</option>
                        <option value="AP">AP</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleFormControlSelect1">DO Status</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="do_status">
                        <option value="" disabled selected>---Select---</option>
                        <option value="Pending">Pending</option>
                        <option value="On Going">On Going</option>
                        <option value="Done">Done</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleFormControlSelect1">Billing Status</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="billing_status">
                        <option value="" disabled selected>---Select---</option>
                        <option value="Pending">Pending</option>
                        <option value="On Going">On Going</option>
                        <option value="Done">Done</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleFormControlSelect1">Delivery</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="delivery_status">
                        <option value="" disabled selected>---Select---</option>
                        <option value="Pending">Pending</option>
                        <option value="On Going">On Going</option>
                        <option value="Done">Done</option>
                        </select>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="add_shipment" class="btn btn-success">Save</button>
                </div>
            </form>
          </div>
        </div>
      </div>
