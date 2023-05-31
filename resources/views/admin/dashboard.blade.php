<link rel="stylesheet" href="/css/dashboard.css" />
@include('layouts.inc.sidebarNav')
@include('layouts.inc.message')
<style>
    .main-menu:hover~#content {
        margin-left: 8%;
    }

    @media only screen and (max-width: 767px) {
        .main-menu:hover~#content {
            margin-left: 0;
        }

        .card {
            left: 20px;
            top: 20px;
            margin: 0;
        }

        #content main {
            margin: 0;
            padding: 24px;
            margin-left: 13%;
        }

        #content main .head-title .left h1 {
            font-size: 24px;
        }

        #content main .head-title .left .breadcrumb li {
            font-size: 12px;
        }

        #content main .head-title .btn-download {
            margin-right: 0;
            margin-top: 10px;
        }

        #content main .box-info li {
            padding: 16px;
        }

        #content main .box-info li .bx {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }

        #content main .box-info li .text h3 {
            font-size: 20px;
        }

        #content main .box-info li .text p {
            font-size: 12px;
        }

        #content main .table-data .head h3 {
            font-size: 20px;
        }

        #content main .table-data .order table th {
            font-size: 10px;
            margin-left: 40%;
        }

        #content main .table-data .order table td {
            padding: 12px 0;
        }

        #content main .table-data .order table tr td .status {
            font-size: 8px;
            padding: 4px 12px;
        }

        #content main .table-data .todo .todo-list li {
            padding: 10px 16px;
        }

        .no-shipment-found {
            font-size: 16px;
            margin-top: 30px;
        }
    }
</style>
<title>MFA Customs Brokerage</title>

<section id="content">
    <main>
        <div class="head-title">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="left">
                <h1>DASHBOARD</h1>
            </div>
            @if (Auth::user()->type == 'admin')
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#activityLogsModal">
                    <i class="fas fa-list"></i> ACTIVITY LOGS
                </button>
            @endif

            <!-- Modal -->
            <div class="modal fade" id="activityLogsModal" tabindex="-1" aria-labelledby="activityLogsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="activityLogsModalLabel">DOWNLOAD ACTIVITY LOGS</h5>
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
                    <p>CONSIGNEES</p>
                </span>
            </li>
            <li>
                <a href="{{ route('shipments') }}"><i class='fa fa-truck mb-2'
                        style="font-size: 50px; color:goldenrod;"></i>
                </a>
                <span class="text">
                    <h3>{{ \App\Models\Shipment::where('status', 0)->count() }}</h3>
                    <p>IN PROCESS SHIPMENTS</p>
                </span>
            </li>
            <li>
                <a href="{{ route('close_shipments') }}">
                    <i class='fa fa-circle-check mb-2' style="font-size: 50px; color:springgreen;"></i>
                </a>
                <span class="text">
                    <h3>{{ \App\Models\Dataset::all()->count() + \App\Models\CloseShipment::all()->count() }}</h3>
                    <p>CLOSED SHIPMENTS</p>
                </span>
            </li>
        </ul>
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>RECENT SHIPMENTS</h3>
                    <i class='bx bx-search'></i>
                    <i class='bx bx-filter'></i>
                </div>
                @if ($shipments->contains('status', 0))
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
                                @if ($shipment->status == 0)
                                    <tr>
                                        <td>
                                            <strong>
                                                <p>{{ $shipment->consignee_name }}</p>
                                            </strong>
                                        </td>
                                        <td>{{ $shipment->arrival_date }}</td>
                                        <td>{{ $shipment->shipping_line }}</td>
                                        {{-- <td>{{ $shipment->port_of_origin }}</td> --}}
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-shipment-found">
                        <p style="font-size: 2rem; text-align: center; opacity: 0.5;">No Recent Shipment Found</p>
                    </div>
                @endif
            </div>
            <div>
                <canvas id="bar-chart" style="height: 400px; width: 400px;"></canvas>
            </div>
        </div>
    </main>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    var data = {
        labels: ['{{ $prev_month->format('M Y') }}', '{{ $today->format('M Y') }}',
            '{{ $next_month->format('M Y') }}'
        ],
        datasets: [
            @foreach ($data as $d)
                {
                    label: '{{ $d['status'] }}',
                    backgroundColor: '{{ $d['status'] === 'Early' ? '#4EA646' : ($d['status'] === 'On-Time' ? '#F0AD4E' : '#D9534F') }}',
                    borderColor: '{{ $d['status'] === 'Early' ? '#4EA646' : ($d['status'] === 'On-Time' ? '#F0AD4E' : '#D9534F') }}',
                    borderWidth: 1,
                    data: {{ json_encode($d['counts']) }}
                },
            @endforeach
        ]
    };

    var options = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: 'top'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    };

    var chart = new Chart(document.getElementById('bar-chart'), {
        type: 'bar',
        data: data,
        options: options
    });
</script>
