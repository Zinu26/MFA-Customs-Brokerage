<div class="modal fade" id="shipmentModal" tabindex="-1" role="dialog" aria-labelledby="shipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shipmentModalLabel">Shipment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>BL Number:</td>
                        <td>{{ $shipment->bl_number }}</td>
                    </tr>
                    <tr>
                        <td>Entry Number:</td>
                        <td>{{ $shipment->entry_number }}</td>
                    </tr>
                    <tr>
                        <td>Arrival Date:</td>
                        <td>{{ $shipment->arrival }}</td>
                    </tr>
                    <!-- Add any other shipment details you want to display here -->
                </table>
            </div>
        </div>
    </div>
</div>
