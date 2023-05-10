<link rel="stylesheet" href="/css/dashboard.css" />
@include('layouts.inc.client_sidenav')
@include('layouts.inc.message')

<title>MFA Customs Brokerage | {{ Auth::user()->name }}</title>

<section id="content">
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Dashboard</h1>
            </div>
            {{-- toggle on/off --}}
            <button><i class="fas fa-bell"></i></button>
        </div>

        <ul class="box-info">
            <li>
                <i class='fa fa-truck mb-2' style="font-size: 50px; color:goldenrod;"></i>
                <span class="text">
                    <h3>{{ Auth::user()->shipments()->count() }}</h3>
                    <p>In Process Shipments</p>
                </span>
            </li>
            <li>
                <i class='fa fa-circle-check mb-2' style="font-size: 50px; color:springgreen;"></i>
                <span class="text">
                    <h3>{{ Auth::user()->closed()->count() }}</h3>
                    <p>Closed Shipments</p>
                </span>
            </li>
        </ul>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Recent Shipments | {{ Auth::user()->name }}</h3>
                    <a href="{{ route('consignee_open_shipment') }}"><button class="btn btn-sm btn-primary"><i
                                class='fa fa-eye'></i> View</button></a>
                    <i class='bx bx-filter'></i>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Consignee</th>
                            <th>Arrival Date</th>
                            <th>Delivery Date</th>
                            <th>Shipping Line</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipments as $shipment)
                            @if ($shipment->consignee_name == Auth::user()->name)
                                <tr>
                                    <td>
                                        <strong>
                                            <p>{{ $shipment->consignee_name }}</p>
                                        </strong>
                                    </td>
                                    <td>{{ $shipment->arrival }}</td>
                                    <td>{{ $shipment->predicted_delivery_date }}</td>
                                    <td>{{ $shipment->shipping_line }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <canvas id="pie-chart"></canvas>
            </div>
        </div>

        @include('chatbot.bot')
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
