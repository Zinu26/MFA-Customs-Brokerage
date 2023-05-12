<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal{{ $shipment->id }}"><i
        class="fa fa-pencil"></i></button>

<!--Add modal-->
<div class="modal fade bd-example-modal-lg" id="editModal{{ $shipment->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Shipment</h1>
            </div>
            <form
                action="@if (Auth::user()->type == 'admin') {{ route('edit_shipment', $shipment->id) }} @elseif(Auth::user()->type == 'employee'){{ route('edit_shipment.employee', $shipment->id) }} @endif"
                method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $shipment->id }}" />
                    <fieldset disabled>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Consignee</span>
                            <input type="text" value="{{ $shipment->consignee_name }}" class="form-control" required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Item
                                Description</span>
                            <input type="text" value="{{ $shipment->item_description }}" class="form-control"
                                required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Size</span>
                            <input type="text" value="{{ $shipment->size }}" class="form-control" required>

                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Weight</span>
                            <input type="text" value="{{ $shipment->weight }}" class="form-control" required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">BL Number</span>
                            <input type="text" value="{{ $shipment->bl_number }}" class="form-control" required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Shipping Line</span>
                            <input type="text" value="{{ $shipment->shipping_line }}" class="form-control" required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Arrival Time</span>
                            <input type="date" value="{{ $shipment->arrival }}" class="form-control" required>
                        </div></br>
                    </fieldset>

                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Process Start</span>
                        <input type="date"
                            @if ($shipment->process_started != null) value="{{ $shipment->process_started }}" @endif
                            name="process_started" placeholder="Process Start" aria-label="Process Start"
                            class="form-control">

                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Process End</span>
                        <input type="date"
                            @if ($shipment->process_ended != null) value="{{ $shipment->process_ended }}" @endif
                            name="process_ended" placeholder="Process End" aria-label="Process End"
                            class="form-control">
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
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
