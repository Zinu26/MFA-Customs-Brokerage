@include('layouts.inc.header')
@include('layouts.inc.sidebarNav')
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
<div class="table">
    <div class="table-header">
        <p>ADMIN LIST</p>
        <div>
            <a href="{{ route('admin_list') }}">
                <button class="btn btn-success"><i class="fas fa-folder-plus"></i><span class="sr-only"> ACTIVE LIST
                    </span></button>
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
                <th class="text-center">NAME</th>
                <th class="text-center">DATE ARCHIVED</th>
                <th class="text-center">USERNAME</th>
                <th class="text-center">OPTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @if ($user->isArchived == true)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ date('Y-m-d h:i A', strtotime($user->updated_at)) }}</td>
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
            <form action="{{ route('add_admin') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Full Name</span>
                        <input type="text" name="name" placeholder="Full Name" aria-label="Full Name"
                            class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Username</span>
                        <input type="text" name="username" placeholder="Username" aria-label="Username"
                            class="form-control" required>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="background-color: #4EA646; font-weight: 600; color: white;">Password</span>
                        <input type="password" name="password" placeholder="Password" aria-label="Password"
                            class="form-control" required>
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
