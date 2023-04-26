@include('layouts.inc.header')
@include('layouts.inc.sidebarNav')
<link rel="stylesheet" href="/css/admin-style.css" />

<div class="table">
    <div class="table-header">
      <p>Admin</p>
      <div>
        <a href="{{route('admin_list')}}">
            <button class="btn btn-success"><i class="fa fa-folder-plus"></i> Active</button>
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
          <th class="text-center">Date Archived</th>
          <th class="text-center">Username</th>
          <th class="text-center">Operation</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
            @if($user->isArchived == true)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>{{ $user->username }}</td>
                    <td class="text-center">
                        @include('admin.adminPanel.restore')
                    </td>
                </tr>
            @endif
        @endforeach
      </tbody>
    </table>
  </div>

    <!--Add modal-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Admin</h1>
        </div>
        <form action="{{route('add_admin')}}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="input-group">
              <span class="input-group-text" style="background-color: #4EA646; font-weight: 600; color: white;">Full Name</span>
              <input type="text" name="name" placeholder="Full Name" aria-label="Full Name" class="form-control" required>
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
          <button type="submit" name="add" class="btn btn-success">Save</button>
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


