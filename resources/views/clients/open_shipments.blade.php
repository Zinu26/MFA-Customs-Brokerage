@include('layouts.inc.header')
@include('layouts.inc.client_sidenav')
<link rel="stylesheet" href="/css/admin-style.css" />
<style>
    .table-header p {
        margin-left: 100px;
        top: 57px;

        font-family: 'Poppins', 'Helvetica Neue', sans-serif;
        font-style: normal;
        font-weight: 700;
        font-size: 50px;

        color: #FFFFFF;
        -webkit-text-stroke-width: 1.5px;
        -webkit-text-stroke-color: black;
        transition: all 0.1s ease;
    }

    #content {
        max-width: 100%;
        padding: 36px 24px;
        font-family: var(--poppins);
        max-height: 100vh;
        overflow-y: auto;
        margin: 0 100px;
        transition: all 0.1s ease;
    }

    .main-menu:hover~#content,
    .main-menu:hover~.table .table-header p {
        margin-left: 13%;
    }

    /* Media query for screens with a maximum width of 767px */
    @media only screen and (max-width: 1080px) {
        .table-header p {
            margin-left: 13%;
            font-size: 30px;
        }

        #content {
            width: 80%;
            margin-left: 13%;
        }
    }
</style>
<title>MFA Customs Brokerage | {{ Auth::user()->name }}</title>
<div class="table">
    <div class="table-header">
        <p>OPEN SHIPMENTS | {{ Auth::user()->name }}</p>
        <div>
            <a href="{{ route('consignee_close_shipment') }}">
                <button class="btn btn-danger"><i class="fas fa-folder-minus"></i><span class="sr-only"> CLOSE
                        SHIPMENTS</span></button>
            </a>
        </div>
    </div>
</div>

@include('layouts.inc.message')

<div id="content">
    <table id="datatableid" class="table table-bordered table-dark">
        <thead>
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">ENTRY NUMBER</th>
                <th class="text-center">BL NUMBER</th>
                <th class="text-center">ARRIVAL DATE</th>
                <th class="text-center">PREDICTED DELIVERY DATE</th>
                <th class="text-center">SHIPMENT STATUS</th>
                <th class="text-center">DO STATUS</th>
                <th class="text-center">BILLING STATUS</th>
                <th class="text-center">OPTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shipments as $shipment)
                @if ($shipment->status != 1)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $shipment->entry_number }}</td>
                        <td>{{ $shipment->bl_number }}</td>
                        <td>{{ $shipment->arrival_date }}</td>
                        <td>
                            @if ($shipment->predicted_delivery_date != null)
                                {{ $shipment->predicted_delivery_date }}
                            @else
                                ----SHIPMENT STILL IN PROCESS----
                            @endif
                        </td>
                        <td>{{ $shipment->shipment_status }}</td>
                        <td>{{ $shipment->do_status }}</td>
                        <td>{{ $shipment->billing_status }}</td>
                        <td class="text-center col-1">
                            @include('admin.clientPanel.view_open_shipments')
                            @include('admin.shipmentPanel.files')
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
    integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
</script>

<!--Search bar-->
<script>
    $(document).ready(function() {
        $('#datatableid').DataTable();
    });
</script>
