<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#viewModal{{$shipment->id}}"><i class="fa fa-eye"></i> View </button>

<div class="modal fade bd-example-modal-lg" id="viewModal{{$shipment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel" >View Shipment</h1>
        </div>
        <form action="{{route('edit_shipment', $shipment->id)}}" method="POST">
        @csrf
            <fieldset disabled>
            <div class="modal-body">
                <input type="hidden" name="id" value="{{$shipment->id}}" />
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Consignee</span>
                        <input type="text" value="{{$shipment->consignee_name}}"  class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Item Description</span>
                        <input type="text" value="{{$shipment->shipment_details}}" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Size</span>
                        <input type="text" value="{{$shipment->shipment_size}}" class="form-control" required>

                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Weight</span>
                        <input type="text" value="{{$shipment->weight}}" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Entry Number</span>
                        <input type="text" value="{{$shipment->entry_number}}" class="form-control" required>

                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">BL Number</span>
                        <input type="text" value="{{$shipment->bl_number}}" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Shipping Line</span>
                        <input type="text" value="{{$shipment->shipping_line}}" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Port of Origin</span>
                        <input type="text" @if($shipment->port_of_origin != null) value="{{$shipment->port_of_origin}}"  @endif name="port_of_origin" placeholder="Port of Origin" aria-label="Port of Origin" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Destination</span>
                        <input type="text" @if($shipment->destination_address != null) value="{{$shipment->destination_address}}"  @endif name="destination_address" placeholder="Destination" aria-label="Destination" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Arrival Time</span>
                        <input type="text" value="{{$shipment->arrival_date}}" class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Process Start</span>
                        <input type="text" @if($shipment->process_started != null) value="{{$shipment->process_started}}"  @endif name="process_started" placeholder="Process Start" aria-label="Process Start" class="form-control">

                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Process End</span>
                        <input type="text" @if($shipment->process_finished!= null) value="{{$shipment->process_finished}}"  @endif name="process_ended" placeholder="Process End" aria-label="Process End" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Delivery Date</span>
                        <input type="text" @if($shipment->delivered_date != null) value="{{$shipment->delivered_date}}"  @endif name="delivered_date" placeholder="Delivery Date" aria-label="Delivery Date" class="form-control">
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Predicted Delivery Date</span>
                        <input type="text" @if($shipment->predicted_delivery_dates != null) value="{{$shipment->predicted_delivery_dates}}"  @endif name="predicted_delivery_dates" placeholder="Predicted Delivery Date" aria-label="Predicted Delivery Date" class="form-control">

                        <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Status</span>
                        <input type="text" @if($shipment->delivery_status != null) value="{{$shipment->delivery_status}}"  @endif name="delivery_status" placeholder="Status" aria-label="Status" class="form-control">
                    </div></br>
            </div>
            </fieldset>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
