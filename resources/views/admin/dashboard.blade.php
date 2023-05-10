<link rel="stylesheet" href="/css/dashboard.css" />
@include('layouts.inc.sidebarNav')
@include('layouts.inc.message')

<title>MFA Customs Brokerage</title>

<section id="content">
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Dashboard</h1>
            </div>
            @if (Auth::user()->type == 0)
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#activityLogsModal">
                    Activity Logs
                </button>
            @endif

            <!-- Modal -->
            <div class="modal fade" id="activityLogsModal" tabindex="-1" aria-labelledby="activityLogsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="activityLogsModalLabel">Download Activity Logs</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Please select an option to download:</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                        data-target="#activityLogsDateModal">Download by Date Range</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('activity-logs.download') }}"
                                        class="btn btn-secondary btn-block">Download All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date Range Modal -->
            <div class="modal fade" id="activityLogsDateModal" tabindex="-1"
                aria-labelledby="activityLogsDateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="activityLogsDateModalLabel">Download Activity Logs by Date Range
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('activity-logs.download') }}" method="GET">
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

        </div>

        <ul class="box-info">
            <li>
                <a href="{{ route('client_list') }}">
                    <i class='fa fa-users mb-2' style="font-size: 50px; color:cornflowerblue;"></i>
                </a>
                <span class="text">
                    <h3>{{ \App\Models\User::where('type', 2)->count() }}</h3>
                    <p>Consignees</p>
                </span>
            </li>
            <li>
                <a href="{{ route('shipments') }}"><i class='fa fa-truck mb-2'
                        style="font-size: 50px; color:goldenrod;"></i>
                </a>
                <span class="text">
                    <h3>{{ \App\Models\Shipment::all()->count() }}</h3>
                    <p>In Process Shipments</p>
                </span>
            </li>
            <li>
                <a href="{{ route('close_shipments') }}">
                    <i class='fa fa-circle-check mb-2' style="font-size: 50px; color:springgreen;"></i>
                </a>
                <span class="text">
                    <h3>{{ \App\Models\Dataset::all()->count() }}</h3>
                    <p>Closed Shipments</p>
                </span>
            </li>
        </ul>


        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Recent Shipments</h3>
                    <i class='bx bx-search'></i>
                    <i class='bx bx-filter'></i>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Consignee</th>
                            <th>Arrival Date</th>
                            <th>Shipping Line</th>
                            {{-- <th>Port of Origin</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipments as $shipment)
                            <tr>
                                <td>
                                    <strong>
                                        <p>{{ $shipment->consignee_name }}</p>
                                    </strong>
                                </td>
                                <td>{{ $shipment->arrival }}</td>
                                <td>{{ $shipment->shipping_line }}</td>
                                {{-- <td>{{ $shipment->port_of_origin }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <canvas id="pie-chart"></canvas>
            </div>
        </div>
    </main>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var labels = {!! json_encode($labels) !!};
    var values = {!! json_encode($values) !!};
    var colors = [
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 99, 132, 0.8)',
        'rgba(255, 205, 86, 0.8)'
    ];

    var data = {
        labels: labels,
        datasets: [{
            data: values,
            backgroundColor: colors
        }]
    };

    var options = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: 'right',
            labels: {
                boxWidth: 15,
                fontColor: 'black',
                fontSize: 13,
                padding: 15,
                fontFamily: 'Arial'
            }
        }
    };

    var ctx = document.getElementById('pie-chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
    });
</script>
