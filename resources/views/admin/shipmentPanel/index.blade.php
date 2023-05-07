@include('layouts.inc.header')
@include('layouts.inc.sidebarNav')
<link rel="stylesheet" href="/css/admin-style.css" />

<title>MFA Customs Brokerage</title>

<div class="table">
    <div class="table-header">
      <p>Shipments</p>
      <div>
        @include('admin.shipmentPanel.create')
        <a href="close_shipments">
            <button class="btn btn-danger"><i class="fa fa-folder-minus"></i> Close Shipments</button>
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
            @if($shipment->status == false)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $shipment->consignee_name }}</td>
                    <td>{{ $shipment->arrival }}</td>
                    <td>{{ $shipment->predicted_delivery_date }}</td>
                    <td>{{ $shipment->do_status }}</td>
                    <td>{{ $shipment->shipment_status }}</td>
                    <td>{{ $shipment->billing_status }}</td>
                    <td>{{ $shipment->delivery_status }}</td>
                    <td>
                        @include('admin.shipmentPanel.view')
                        @include('admin.shipmentPanel.edit')
                    </td>
                </tr>
            @endif
        @endforeach
      </tbody>
    </table>
  </div>



  <!--Edit modal-->
  <div class="modal fade bd-example-modal-lg" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
        </div>
        <div class="modal-body">
        <form action="function.php" method="POST">
            <input type="hidden" name="id" id="id">
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Consignee</span>
              <input type="text" name="consignee" placeholder="Consignee" id="consignee" aria-label="Consignee" class="form-control" required>
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Item</span>
              <input type="text" name="item" placeholder="Item" aria-label="Item" id="item" class="form-control" required>
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Size of item</span>
              <input type="text" name="size" placeholder="Size of item" id="size" aria-label="Size of item" class="form-control" required>
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">BL Number</span>
              <input type="text" name="BL_number" placeholder="BL Number" id="BL_number" aria-label="BL Number" class="form-control" required>
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Shipping Line</span>
              <input type="text" name="shipping_line" placeholder="Shipping Line" id="shipping_number" aria-label="Shipping Line" class="form-control" required>
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Arrival Time</span>
              <input type="date" name="arrival_time" placeholder="Arrival Time" id="arrival" aria-label="Arrival Time" class="form-control" required>
            </div></br>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="exampleFormControlSelect1">Shipment Status</label>
                <select class="form-control" id="shipment_status" name="shipment_status">
                  <option value="AG">AG</option>
                  <option value="AS">AS</option>
                  <option value="AP">AP</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleFormControlSelect1">DO Status</label>
                <select class="form-control" id="do_status" name="do_status">
                  <option value="done">Done</option>
                  <option value="pending">Pending</option>
                  <option value="on_going">On Going</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleFormControlSelect1">Billing Status</label>
                <select class="form-control" id="billing" name="billing">
                  <option value="done">Done</option>
                  <option value="pending">Pending</option>
                  <option value="on_going">On Going</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleFormControlSelect1">Delivery</label>
                <select class="form-control" id="delivery" name="delivery">
                  <option value="done">Done</option>
                  <option value="pending">Pending</option>
                  <option value="on_going">On Going</option>
                </select>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="update" class="btn btn-success">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!--Hide modal-->
  <div class="modal fade" id="deletemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Hide Admin</h1>
        </div>
        <form action="function.php" method="POST">
          <div class="modal-body">
              <input type="hidden" name="delete_id" id="delete_id">
              <h4>Do you want to hide this data?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            <button type="submit" name="delete" class="btn btn-danger">Yes</button>
          </div>
    </form>
      </div>
    </div>
  </div>

  <!--View modal-->
  <div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">View Profile</h1>
        </div>
        <div class="modal-body">
        <fieldset disabled>
            <input type="hidden" name="id" id="id">
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Name</span>
              <input type="text" name="fname" id="fname1" placeholder="Given name" aria-label="Given name" class="form-control" required>
              <input type="text" name="mname" id="mname1" placeholder="Middle name" aria-label="Middle name" class="form-control">
              <input type="text" name="lname" id="lname1" placeholder="Surname" aria-label="Surname" class="form-control" required>
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">ID Number</span>
              <input type="text" name="id_number" id="id_number1" placeholder="ID Number" aria-label="ID Number" class="form-control" required>
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Contact Number</span>
              <input type="text" name="contact" id="contact1" placeholder="Contact Number" aria-label="Contact Number" class="form-control" required>
            </div></br>
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Username</span>
              <input type="text" name="username" id="username1" placeholder="Username" aria-label="Username" class="form-control" required>
            </div></br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>

    </fieldset>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

  <!--Search bar-->
  <script>
    $(document).ready( function () {
        $('#datatableid').DataTable();
    } );
  </script>

  <!--view-->
  <script type='text/javascript'>
    $(document).ready(function(){
      $('.viewbtn').on('click', function(){
        $('#viewmodal').modal('show');

          $tr = $(this).closest('tr');

          var data = $tr.children("td").map(function(){
            return $(this).text();
          }).get();

          console.log(data);

          $('#id1').val(data[0]);
          $('#fname1').val(data[1]);
          $('#mname1').val(data[2]);
          $('#lname1').val(data[3]);
          $('#id_number1').val(data[4]);
          $('#contact1').val(data[6]);
          $('#username1').val(data[7]);
      });
    });
  </script>

  <!--edit-->
  <script type='text/javascript'>
    $(document).ready(function(){
      $('.editbtn').on('click', function(){
        $('#editmodal').modal('show');

          $tr = $(this).closest('tr');

          var data = $tr.children("td").map(function(){
            return $(this).text();
          }).get();

          console.log(data);

          $('#id').val(data[0]);
          $('#consignee').val(data[1]);
          $('#BL_number').val(data[4]);
          $('#shipping_line').val(data[6]);
          $('#arrival').val(data[3]);
          $('#shipment_status').val(data[6]),
          $('#do_status').val(data[6]),
          $('#billing').val(data[6]),
          $('#delivery').val(data[6]);
      });
    });
  </script>

  <!--delete-->
  <script type='text/javascript'>
    $(document).ready(function(){
      $('.dltbtn').on('click', function(){
        $('#deletemodal').modal('show');

          $tr = $(this).closest('tr');

          var data = $tr.children("td").map(function(){
            return $(this).text();
          }).get();

          console.log(data);

          $('#delete_id').val(data[0]);
      });
    });
  </script>

  <script>
    function close_shipment(){
          window.location='http://localhost/MFA/admin/close_shipments.php';
      }
  </script>
