<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $shipment->id }}"><i
        class="fa fa-eye"></i></button>

<!--View modal-->
<div class="modal fade bd-example-modal-lg" id="viewModal{{ $shipment->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">View Shipment</h1>
            </div>
            <fieldset disabled>
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $shipment->id }}" />
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Consignee</span>
                        <input type="text" value="{{ $shipment->consignee_name }}" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Item
                            Description</span>
                        <input type="text" value="{{ $shipment->shipment_details }}" class="form-control" required>
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
                            style="background-color: #4EA646; font-weight: 600; color: white;">Entry Number</span>
                        <input type="text" value="{{ $shipment->entry_number }}" name="entry_number"
                            placeholder="Entry Number" aria-label="Entry Number" class="form-control" required>

                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">BL Number</span>
                        <input type="text" value="{{ $shipment->bl_number }}" name="BL_number"
                            placeholder="BL Number" aria-label="BL Number" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Shipping Line</span>
                        <input type="text" value="{{ $shipment->shipping_line }}" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Arrival Date</span>
                        <input type="date" value="{{ date('Y-m-d', strtotime($shipment->arrival_date)) }}"
                            class="form-control" required>
                    </div></br>
                    @if ($shipment->process_started != null || $shipment->process_finished != null)
                        <div class="input-group">
                            @if ($shipment->process_started != null)
                                <span class="input-group-text"
                                    style="background-color: #4EA646; font-weight: 600; color: white;">Process
                                    Start</span>
                                <input type="date"
                                    @if ($shipment->process_started != null) value="{{ date('Y-m-d', strtotime($shipment->process_started)) }}" @endif
                                    name="process_started" placeholder="Process Start" aria-label="Process Start"
                                    class="form-control">
                            @endif
                            @if ($shipment->process_finished != null)
                                <span class="input-group-text"
                                    style="background-color: #4EA646; font-weight: 600; color: white;">Process
                                    End</span>
                                <input type="date"
                                    @if ($shipment->process_finished != null) value="{{ date('Y-m-d', strtotime($shipment->process_finished)) }}" @endif
                                    name="process_ended" placeholder="Process End" aria-label="Process End"
                                    class="form-control">
                            @endif
                        </div></br>
                    @endif
                    @if ($shipment->predicted_delivery_date != null)
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Predicted
                                Delivery Date</span>
                            <input type="text"
                                @if ($shipment->predicted_delivery_date != null) value="{{ \Carbon\Carbon::parse($shipment->predicted_delivery_date)->format('d M Y') }}" readonly @endif
                                name="predicted_delivery_date" placeholder="Predicted Delivery Date"
                                aria-label="Predicted Delivery Date" class="form-control">
                        </div></br>
                    @endif

                    @if ($shipment->delivered_date != null)
                        <div class="input-group">
                            <span class="input-group-text"
                                style="background-color: #4EA646; font-weight: 600; color: white;">Actual Delivery
                                Date</span>
                            <input type="text"
                                @if ($shipment->delivered_date != null) value="{{ \Carbon\Carbon::parse($shipment->delivered_date)->format('d M Y') }}" readonly @endif
                                name="delivered_date" placeholder="Actual Delivery Date"
                                aria-label="Actual Delivery Date" class="form-control">
                        </div></br>
                    @endif

                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Port of
                            origin</span>
                        <input type="text"
                            @if ($shipment->port_of_origin != null) value="{{ $shipment->port_of_origin }}"  readonly @endif
                            name="port_of_origin" placeholder="Port of origin" aria-label="Port of origin"
                            class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Destination
                            Address</span>
                        <input type="text"
                            @if ($shipment->destination_address != null) value="{{ $shipment->destination_address }}"  readonly @endif
                            name="destination_address" placeholder="Destination Address"
                            aria-label="Destination Address" class="form-control">
                    </div></br>
                </div>
            </fieldset>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
