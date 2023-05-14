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
        </div>

        @include('chatbot.bot')
    </main>
</section>
