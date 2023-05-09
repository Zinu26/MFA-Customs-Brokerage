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
                <form action="{{ route('edit_shipment', $shipment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $shipment->id }}" />
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Consignee</span>
                            <input type="text" value="{{ $shipment->consignee_name }}" class="form-control" readonly>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Item
                                Description</span>
                            <input type="text" value="{{ $shipment->item_description }}" class="form-control"
                                readonly>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Size</span>
                            <input type="text" value="{{ $shipment->size }}" class="form-control" readonly>

                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Weight</span>
                            <input type="text" value="{{ $shipment->weight }}" class="form-control" readonly>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">BL Number</span>
                            <input type="text" value="{{ $shipment->bl_number }}" class="form-control" readonly>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Shipping Line</span>
                            <input type="text" value="{{ $shipment->shipping_line }}" class="form-control" readonly>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Arrival Time</span>
                            <input type="date" value="{{ $shipment->arrival }}" class="form-control" readonly>
                        </div></br>

                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Process Start</span>
                            <input type="date"
                                @if ($shipment->process_started != null) value="{{ $shipment->process_started }}"  readonly @endif
                                name="process_started" placeholder="Process Start" aria-label="Process Start"
                                class="form-control">

                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Process End</span>
                            <input type="date"
                                @if ($shipment->process_finished != null) value="{{ $shipment->process_finished }}"  readonly @endif
                                name="process_ended" placeholder="Process End" aria-label="Process End"
                                class="form-control">
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Port of origin</span>
                            {{-- <input type="date" @if ($shipment->port_of_origin != null) value="{{$shipment->port_of_origin}}"  readonly @endif name="port_of_origin" placeholder="Port of origin" aria-label="Port of origin" class="form-control"> --}}
                            <select class="form-control" id="port_of_origin{{ $shipment->id }}" name="port_of_origin">
                                <option value="" disabled selected>---Select---</option>
                                <option value="MANILA NORTH PORT, PHILIPPINES" {{ $shipment->port_of_origin == 'MANILA NORTH PORT, PHILIPPINES' ? 'selected' : '' }}>MANILA NORTH PORT, PHILIPPINES
                                </option>
                                <option value="MANILA SOUTH PORT, PHILIPPINES" {{ $shipment->port_of_origin == 'MANILA SOUTH PORT, PHILIPPINES' ? 'selected' : '' }}>MANILA SOUTH PORT, PHILIPPINES
                                </option>
                            </select>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Destination
                                Address</span>
                            <input type="text" readonly name="destination_address" value="{{$shipment->destination_address}}" placeholder="Destination Address"
                                aria-label="Destination Address" class="form-control">
                        </div></br>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="shipmentStatus{{ $shipment->id }}">Shipment Status</label>
                                <select class="form-control" id="shipmentStatus{{ $shipment->id }}"
                                    name="shipment_status">
                                    <option value="" disabled selected>---Select---</option>
                                    <option value="AG" {{ $shipment->shipment_status == 'AG' ? 'selected' : '' }}>
                                        AG</option>
                                    <option value="AS" {{ $shipment->shipment_status == 'AS' ? 'selected' : '' }}>
                                        AS</option>
                                    <option value="AP" {{ $shipment->shipment_status == 'AP' ? 'selected' : '' }}>
                                        AP</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="doStatus{{ $shipment->id }}">DO Status</label>
                                <select class="form-control" id="doStatus{{ $shipment->id }}" name="do_status">
                                    <option value="" disabled selected>---Select---</option>
                                    <option value="Pending" {{ $shipment->do_status == 'Pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="On Going"
                                        {{ $shipment->do_status == 'On Going' ? 'selected' : '' }}>On Going</option>
                                    <option value="Done" {{ $shipment->do_status == 'Done' ? 'selected' : '' }}>Done
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="billingStatus{{ $shipment->id }}">Billing Status</label>
                                <select class="form-control" id="billingStatus{{ $shipment->id }}"
                                    name="billing_status">
                                    <option value="" disabled selected>---Select---</option>
                                    <option value="Pending"
                                        {{ $shipment->billing_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="On Going"
                                        {{ $shipment->billing_status == 'On Going' ? 'selected' : '' }}>On Going
                                    </option>
                                    <option value="Done"
                                        {{ $shipment->billing_status == 'Done' ? 'selected' : '' }}>Done</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="deliveryStatus{{ $shipment->id }}">Delivery Status</label>
                                <input type="text"  name="delivery_status" @if($shipment->process_started != null) value="On Going" @endif @if($shipment->delivered_date != null) value="Done" @endif value="{{$shipment->delivery_status}}" placeholder="Delivery Status"
                                aria-label="Delivery Status" class="form-control" readonly>
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
