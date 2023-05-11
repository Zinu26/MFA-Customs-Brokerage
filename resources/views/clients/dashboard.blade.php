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
            @include('clients.notification')
        </div>

        <ul class="box-info">
            <li>
                <i class='fa fa-clock mb-2' style="font-size: 50px; color:cornflowerblue;"></i>
                <span class="text">
                    <h3>{{ Auth::user()->shipments()->whereNotNull('process_started')->whereNull('process_finished')->count() }}</h3>
                    <p>In Process Shipments</p>
                </span>
            </li>
            <li>
                <i class='fa fa-truck mb-2' style="font-size: 50px; color:goldenrod;"></i>
                <span class="text">
                    <h3>{{ Auth::user()->shipments()->whereNotNull('predicted_delivery_date')->count() }}</h3>
                    <p>To Deliver Shipments</p>
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
                {{-- RECENT SHIPMENTS --}}
                <div class="head">
                    <h3>To Deliver Shipments</h3>
                    <i class='bx bx-filter'></i>
                </div>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>BL Number</th>
                            <th class="text-center">Arrival Date</th>
                            <th class="text-center">Delivery Date</th>
                            <th class="text-center">Shipping Line</th>
                        </tr>
                    </thead>
                    <tbody class="table-light" style="color: black;">
                        @foreach ($shipments as $shipment)
                            @if ($shipment->consignee_name == Auth::user()->name)
                                @if ($shipment->predicted_delivery_date != null)
                                    <tr>
                                        <td>
                                            <strong>
                                                {{ $shipment->bl_number }}
                                            </strong>
                                        </td>
                                        <td class="text-center">{{ $shipment->arrival }}</td>
                                        <td class="text-center">{{ $shipment->predicted_delivery_date }}</td>
                                        <td class="text-center">{{ $shipment->shipping_line }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>

                {{-- TO DELIVER --}}
                <div class="head">
                    <h3>In Process Shipments</h3>
                    <i class='bx bx-filter'></i>
                </div>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>BL Number</th>
                            <th class="text-center">Arrival Date</th>
                            <th class="text-center">Process Started</th>
                            <th class="text-center">Shipping Line</th>
                        </tr>
                    </thead>
                    <tbody class="table-light" style="color: black;">
                        @foreach ($shipments as $shipment)
                            @if ($shipment->consignee_name == Auth::user()->name)
                                @if ($shipment->process_started != null && $shipment->process_finished == null)
                                    <tr>
                                        <td>
                                            <strong>
                                                <p>{{ $shipment->bl_number }}</p>
                                            </strong>
                                        </td>
                                        <td class="text-center">{{ $shipment->arrival }}</td>
                                        <td class="text-center">{{ $shipment->process_started }}</td>
                                        <td class="text-center">{{ $shipment->shipping_line }}</td>
                                    </tr>
                                @endif
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
{{-- Graph --}}
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
