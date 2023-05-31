@include('layouts.inc.header')
@include('layouts.inc.sidebarNav')
<link rel="stylesheet" href="/css/admin-style.css" />
<title>MFA Customs Brokerage</title>
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
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addModal"><i
                    class="fas fa-user-plus"></i><span class="sr-only"> ADD ADMIN </span></button>
            <a href="{{ route('admin_archive_list') }}">
                <button class="btn btn-danger"><i class="fas fa-folder-minus"></i><span class="sr-only"> ARCHIVE LIST</span></button>
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
                <th class="text-center">DATE ADDED</th>
                <th class="text-center">DATE UPDATED</th>
                <th class="text-center">USERNAME</th>
                <th class="text-center">OPTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @if ($user->isArchived != true)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ date('Y-m-d h:i A', strtotime($user->created_at)) }}</td>
                        <td>{{ date('Y-m-d h:i A', strtotime($user->updated_at)) }}</td>
                        <td>{{ $user->username }}</td>
                        <td class="text-center">
                            @if (Auth::user()->name != $user->name)
                                @include('admin.adminPanel.edit')
                                @include('admin.adminPanel.archive')
                            @else
                                <p>------------</p>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

<!--Add modal-->
<div class="modal top fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">ADD ADMIN</h5>
                <a style="cursor: pointer;" data-bs-dismiss="modal"><i class="fa fa-xmark"></i></a>
            </div>
            <form action="{{ route('add_admin') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Full Name</span>
                        <input type="text" name="name" placeholder="Full Name" aria-label="Full Name"
                            class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Username</span>
                        <input type="text" name="username" placeholder="Username" aria-label="Username"
                            class="form-control @error('username') is-invalid @enderror" required>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Email</span>
                        <input type="text" name="email" placeholder="Email" aria-label="Email"
                            class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text w-25 text-white text-center"
                            style="background-color: #4EA646; font-weight: 600;">Password</span>
                        <input type="password" name="password" placeholder="Password" aria-label="Password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                    <button type="submit" name="add" class="btn btn-success">SAVE</button>
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
