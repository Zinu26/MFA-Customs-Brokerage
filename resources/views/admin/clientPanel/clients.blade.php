@include('layouts.inc.header')
@include('layouts.inc.sidebarNav')
<link rel="stylesheet" href="/css/admin-style.css" />
<title>MFA Customs Brokerage</title>

<div class="table">
    <div class="table-header">
        <p>Consignees</p>
        <div>
            @if(Auth::user()->type == 'admin')
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                    class="fa fa-user-plus"></i> Add Consignee</button>
            @endif
            <a
                href="@if (Auth::user()->type == 'admin') {{ route('consignee_archive_list') }} @elseif(Auth::user()->type == 'employee'){{ route('consignee_archive_list.employee') }} @endif">
                <button class="btn btn-danger"><i class="fa fa-folder-minus"></i> Archive</button>
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
                <th class="text-center">Name of Consignee</th>
                <th class="text-center">TIN Number</th>
                <th class="text-center">Email</th>
                <th class="text-center">Address</th>
                <th class="text-center">Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                @if ($client->status == false)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="@if (Auth::user()->type == 'admin') {{ route('open_shipment', $client->id) }} @elseif(Auth::user()->type == 'employee') {{ route('open_shipment.employee', $client->id) }} @endif"
                                style="text-decoration: none; color:#fff;">{{ $client->user->name }}</a></td>
                        <td>{{ $client->tin }}</td>
                        <td>{{ $client->user->email }}</td>
                        <td>{{ $client->address }}</td>
                        @if(Auth::user()->type == 'admin')
                        <td class="text-center col-2">
                        @elseif(Auth::user()->type == 'employee')
                        <td class="text-center col-1">
                        @endif
                            @include('admin.clientPanel.view')
                            @if(Auth::user()->type == 'admin')
                                @include('admin.clientPanel.edit')
                                @include('admin.clientPanel.archive')
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

<!--Add modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Consignee</h1>
            </div>
            <form action="@if(Auth::user()->type == 'admin'){{ route('add_client') }}@elseif(Auth::user()->type == 'employee'){{ route('add_client.employee') }} @endif" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Name of Consignee</span>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                            required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">TIN Number</span>
                        <input type="text" name="tin" id="tin"
                            class="form-control @error('tin') is-invalid @enderror" placeholder="TIN Number" required>
                        @error('tin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Contact Number</span>
                        <input type="text" name="contact" id="contact" class="form-control"
                            placeholder="Contact Number" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Email</span>
                        <input type="text" name="email" placeholder="Email" aria-label="Email"
                            class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Address</span>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Address"
                            required>
                    </div></br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_client" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
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
