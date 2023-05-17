<link rel="stylesheet" href="/css/dashboard.css" />
@include('layouts.inc.client_sidenav')
@include('layouts.inc.message')

<title>MFA Customs Brokerage | {{ Auth::user()->name }}</title>

<section id="content">
    <main>
        <div class="head-title">
        @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{session()->get('message')}}
            </div>
        @endif
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
                    <h3>{{ Auth::user()->shipments()->whereNotNull('delivered_date')->whereNull('delivered_date')->count() }}</h3>
                    <p>To Deliver Shipments</p>
                </span>
            </li>
            <li>
                <i class='fa fa-circle-check mb-2' style="font-size: 50px; color:springgreen;"></i>
                <span class="text">
                    <h3>{{ Auth::user()->closed()->count() + Auth::user()->dataset()->count() }}</h3>
                    <p>Closed Shipments</p>
                </span>
            </li>
        </ul>

        <div class="table-data">
            <div class="order">

                {{-- IN PROCESS --}}
                <div class="head">
                    <h3>In Process Shipments</h3>
                    <i class='bx bx-filter'></i>
                    <a href="{{route('consignee_open_shipment')}}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                    @include('clients.report')
                </div>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>BL Number</th>
                            <th class="text-center">Predicted Delivery Date</th>
                            <th class="text-center">Arrival Date</th>
                            <th class="text-center">Process Start Date</th>
                            <th class="text-center">Process End Date</th>
                            <th class="text-center">Shipping Line</th>
                        </tr>
                    </thead>
                    <tbody class="table-light" style="color: black;">
                        @foreach ($shipments as $shipment)
                            @if ($shipment->consignee_name == Auth::user()->name)
                                @if ($shipment->process_started != null && $shipment->process_finished != null && $shipment->status != 1)
                                    <tr>
                                        <td>
                                            <strong>
                                                <p>{{ $shipment->bl_number }}</p>
                                            </strong>
                                        </td>
                                        <td class="text-center">@if($shipment->predicted_delivery_date != null){{ $shipment->predicted_delivery_date }} @else ------SHIPMENT IS STILL IN PROCESS------ @endif</td>
                                        <td class="text-center">{{ $shipment->arrival }}</td>
                                        <td class="text-center">{{ $shipment->process_started }}</td>
                                        <td class="text-center">{{ $shipment->process_finished }}</td>
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
