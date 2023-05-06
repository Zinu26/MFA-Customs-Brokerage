@include('layouts.inc.header')
@include('layouts.inc.sidebarNav')
<link rel="stylesheet" href="/css/admin-style.css" />
<title>MFA Customs Brokerage</title>

<div class="table">
    <div class="table-header">
      <p>Employees</p>
      <div>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-user-plus"></i> Add Employee</button>
        <a href="{{route('employee_archived_list')}}">
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
            <th class="text-center">Name</th>
            <th class="text-center">Position</th>
            <th class="text-center">Birth date</th>
            <th class="text-center">Contact Number</th>
            <th class="text-center">Email</th>
            <th class="text-center">Username</th>
            <th class="text-center">Operation</th>
        </tr>
      </thead>

      <tbody>
        @foreach($users as $user)
            @if($user->isArchived == false)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->employee->position }}</td>
                    <td>{{ $user->employee->birthdate }}</td>
                    <td>{{ $user->employee->contact_number }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td class="text-center">
                        @include('admin.employeePanel.view')
                        @include('admin.employeePanel.edit')
                        @include('admin.employeePanel.archive')
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
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee</h1>
        </div>
        <form action="{{route('add_employee')}}" method="POST">
        @csrf
            <div class="modal-body">
                <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Full Name</span>
                <input type="text" name="name" placeholder="Full Name" aria-label="Full Name" class="form-control" required>
                </div></br>
                <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Position</span>
                <input type="text" name="position" placeholder="Position" aria-label="Position" class="form-control" required>
                </div></br>
                <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Birthdate</span>
                <input type="date" name="birthdate" placeholder="Birthdate" aria-label="Birthdate" class="form-control" required>
                </div></br>
                <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Contact Number</span>
                <input type="text" name="contact_number" placeholder="Contact Number" aria-label="Contact Number" class="form-control" required>
                </div></br>
                <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Email</span>
                <input type="text" name="email" placeholder="Email" aria-label="Email" class="form-control" required>
                </div></br>
                <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Username</span>
                <input type="text" name="username" placeholder="Username" aria-label="Username" class="form-control" required>
                </div></br>
                <div class="input-group">
                <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Password</span>
                <input type="password" name="password" placeholder="Password" aria-label="Password" class="form-control" required>
                </div></br>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
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
