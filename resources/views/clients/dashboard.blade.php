<link rel="stylesheet" href="/css/dashboard.css" />
@include('layouts.inc.client_sidenav')
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
<title>MFA Customs Brokerage | {{ Auth::user()->name }}</title>

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
                <h1>DASHBOOARD</h1>
            </div>
            {{-- toggle on/off --}}
            @include('clients.notification')
        </div>

        <ul class="box-info">
            <li>
                <i class='fa fa-clock mb-2' style="font-size: 50px; color:cornflowerblue;"></i>
                <span class="text">
                    <h3>{{ $OnProcess }}</h3>
                    <p>IN PROCESS SHIPMENTS</p>
                </span>
            </li>
            <li>
                <i class='fa fa-truck mb-2' style="font-size: 50px; color:goldenrod;"></i>
                <span class="text">
                    <h3>{{ $ToDeliver }}
                    </h3>
                    <p>TO DELIVER SHIPMENTS</p>
                </span>
            </li>
            <li>
                <i class='fa fa-circle-check mb-2' style="font-size: 50px; color:springgreen;"></i>
                <span class="text">
                    <h3>{{ $Closed }}</h3>
                    <p>CLOSED SHIPMENTS</p>
                </span>
            </li>
        </ul>

        <div class="table-data">
            <div class="order">

                {{-- IN PROCESS --}}
                <div class="head">
                    <h3>IN PROCESS SHIPMENTS</h3>
                    <i class='bx bx-filter'></i>
                    <a href="{{ route('consignee_open_shipment') }}" class="btn btn-sm btn-primary"><i
                            class="fa fa-eye"></i> View</a>
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
                                @if ($shipment->process_started != null && $shipment->status != 1)
                                    <tr>
                                        <td>
                                            <strong>
                                                <p>{{ $shipment->bl_number }}</p>
                                            </strong>
                                        </td>
                                        <td class="text-center">
                                            @if ($shipment->predicted_delivery_date != null)
                                                {{ $shipment->predicted_delivery_date }}
                                            @else
                                                ------SHIPMENT IS STILL IN PROCESS------
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $shipment->arrival_date }}</td>
                                        <td class="text-center">{{ $shipment->process_started }}</td>
                                        <td class="text-center">
                                            @if ($shipment->process_finished != null)
                                                {{ $shipment->process_finished }}
                                            @else
                                                ----------------
                                            @endif
                                        </td>
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
