@include('layouts.inc.header')
@include('layouts.inc.client_sidenav')
<link rel="stylesheet" href="/css/admin-style.css" />

<title>MFA Customs Brokerage</title>
<div class="table">
    <div class="table-header">
      <p>Shipments</p>
      <div>
        <a href="{{route('consignee_close_shipment')}}">
            <button class="btn btn-danger"><i class="fa fa-folder-minus"></i> Close Shipments</button>
        </a>
      </div>
    </div>
</div>

<div id="content">
    <table id="datatableid" class="table table-bordered table-dark">
      <thead>
        <tr>
            <th class="text-center">S.N.</th>
            <th class="text-center">Consignees</th>
            <th class="text-center">Arrival</th>
            <th class="text-center">Predicted Delivery Date</th>
            <th class="text-center">DO Status</th>
            <th class="text-center">Shipment Status</th>
            <th class="text-center">Billing</th>
            <th class="text-center">Delivery</th>
            <th class="text-center">Option</th>
        </tr>
      </thead>
      <tbody>
        @foreach($shipments as $shipment)
            <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $shipment->consignee_name }}</td>
                    <td>{{ $shipment->arrival }}</td>
                    <td>{{ $shipment->predicted_delivery_date }}</td>
                    <td>{{ $shipment->do_status }}</td>
                    <td>{{ $shipment->shipment_status }}</td>
                    <td>{{ $shipment->billing_status }}</td>
                    <td>{{ $shipment->delivery_status }}</td>
                    <td  class="text-center col-2">
                        @include('admin.clientPanel.view_open_shipments')
                    </td>
                </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

  <!--Search bar-->
  <script>
    $(document).ready( function () {
        $('#datatableid').DataTable();
    } );
  </script>
