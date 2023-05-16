<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#reportModal"><i class="fa fa-download"></i> Generate Shipment Record</button>

<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="reportModalLabel">Download Shipment Report</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Please select an option to download:</p>
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                        data-target="#reportDateModal">Download by Date Range</button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('downloadCsv') }}"
                        class="btn btn-secondary btn-block">Download All</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Date Range Modal -->
<div class="modal fade" id="reportDateModal" tabindex="-1"
aria-labelledby="reportDateModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="reportDateModalLabel">Download Shipment Report by Date Range
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{route('downloadCsv_by_date')}}" method="GET">
                @csrf
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" class="form-control" id="start_date">
                </div>
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" class="form-control" id="end_date">
                </div>
                <button type="submit" class="btn btn-primary">Download</button>
            </form>
        </div>
    </div>
</div>
</div>
