<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal{{ $shipment->id }}"><i
        class="fas fa-pencil"></i></button>

<!--Add modal-->
<div class="modal fade bd-example-modal-lg" id="editModal{{ $shipment->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">EDIT SHIPMENT</h5>
                <a style="cursor: pointer;" data-bs-dismiss="modal"><i class="fa fa-xmark"></i></a>
            </div>
            <form
                action="@if (Auth::user()->type == 'admin') {{ route('edit_shipment', $shipment->id) }} @elseif(Auth::user()->type == 'employee'){{ route('edit_shipment.employee', $shipment->id) }} @endif"
                method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $shipment->id }}" />
                    <fieldset disabled>
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Consignee</span>
                            <input type="text" value="{{ $shipment->consignee_name }}" class="form-control" required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Item
                                Description</span>
                            <input type="text" value="{{ $shipment->shipment_details }}" class="form-control"
                                required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Size</span>
                            <input type="text" value="{{ $shipment->size }}" class="form-control" required>

                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Weight</span>
                            <input type="text" value="{{ $shipment->weight }}" class="form-control" required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">BL Number</span>
                            <input type="text" value="{{ $shipment->bl_number }}" class="form-control" required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Shipping Line</span>
                            <input type="text" value="{{ $shipment->shipping_line }}" class="form-control" required>
                        </div></br>
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Arrival Date</span>
                            <input type="date" value="{{ $shipment->arrival_date }}" class="form-control" required>
                        </div></br>
                    </fieldset>

                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Process Start</span>
                        <input type="date"
                            @if ($shipment->process_started != null) value="{{ $shipment->process_started }}"  readonly @endif
                            name="process_started" placeholder="Process Start" aria-label="Process Start"
                            class="form-control">
                        @if ($shipment->process_started != null)
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Process End</span>
                            <input type="date"
                                @if ($shipment->process_finished != null) value="{{ $shipment->process_finished }}"  readonly @endif
                                name="process_ended" placeholder="Process End" aria-label="Process End"
                                class="form-control">
                        @endif
                    </div></br>
                    {{-- Predicted Delivered Date --}}
                    @if ($shipment->predicted_delivery_date != null)
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Predicted
                                Delivery Date</span>
                            <input type="date" name="predicted_delivery_date"
                                value="{{ $shipment->predicted_delivery_date }}" class="form-control" readonly>
                        </div></br>
                        {{-- Delivered Date --}}
                        <div class="input-group">
                            <span class="input-group-text w-25 text-white text-center"
                                style="background-color: #4EA646; font-weight: 600;">Delivered
                                Date</span>
                            <input type="date" name="delivered_date"
                                @if ($shipment->delivered_date != null) value="{{ $shipment->delivered_date }}"  readonly @endif
                                class="form-control">
                        </div></br>
                    @endif

                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Port of origin</span>
                        <select class="form-control" id="port_of_origin{{ $shipment->id }}" name="port_of_origin">
                            <option value="" disabled selected>---Select---</option>
                            <option value="MANILA NORTH PORT, PHILIPPINES"
                                {{ $shipment->port_of_origin == 'MANILA NORTH PORT, PHILIPPINES' ? 'selected' : '' }}>
                                MANILA NORTH PORT, PHILIPPINES
                            </option>
                            <option value="MANILA SOUTH PORT, PHILIPPINES"
                                {{ $shipment->port_of_origin == 'MANILA SOUTH PORT, PHILIPPINES' ? 'selected' : '' }}>
                                MANILA SOUTH PORT, PHILIPPINES
                            </option>
                        </select>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Destination
                            Address</span>
                        <input type="text" readonly name="destination_address"
                            value="{{ $shipment->destination_address }}" placeholder="Destination Address"
                            aria-label="Destination Address" class="form-control">
                    </div></br>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="shipmentStatus{{ $shipment->id }}"><strong>Shipment
                                    Status</strong></label>
                            <select class="form-control" id="shipmentStatus{{ $shipment->id }}"
                                name="shipment_status">
                                <option value="" disabled selected>---Select---</option>
                                <option value="AS" {{ $shipment->shipment_status == 'AS' ? 'selected' : '' }}>
                                    AS</option>
                                <option value="AG" {{ $shipment->shipment_status == 'AG' ? 'selected' : '' }}>
                                    AG</option>
                                <option value="AP" {{ $shipment->shipment_status == 'AP' ? 'selected' : '' }}>
                                    AP</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="doStatus{{ $shipment->id }}"><strong>DO Status</strong></label>
                            <select class="form-control" id="doStatus{{ $shipment->id }}" name="do_status">
                                <option value="" disabled selected>---Select---</option>
                                <option value="Pending" {{ $shipment->do_status == 'Pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="On Going" {{ $shipment->do_status == 'On Going' ? 'selected' : '' }}>On
                                    Going</option>
                                <option value="Done" {{ $shipment->do_status == 'Done' ? 'selected' : '' }}>Done
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="billingStatus{{ $shipment->id }}"><strong>Billing Status</strong></label>
                            <select class="form-control" id="billingStatus{{ $shipment->id }}"
                                name="billing_status">
                                <option value="" disabled selected>---Select---</option>
                                <option value="Pending"
                                    {{ $shipment->billing_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="On Going"
                                    {{ $shipment->billing_status == 'On Going' ? 'selected' : '' }}>On Going
                                </option>
                                <option value="Done" {{ $shipment->billing_status == 'Done' ? 'selected' : '' }}>
                                    Done</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                    <button type="submit" class="btn btn-success">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
