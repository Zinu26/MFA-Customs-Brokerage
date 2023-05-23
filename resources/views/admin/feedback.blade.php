@include('layouts.inc.header')
@include('layouts.inc.sidebarNav')
<link rel="stylesheet" href="/css/admin-style.css" />
<title>MFA Customs Brokerage</title>

<div class="table">
    <div class="table-header">
        <p>Feedbacks</p>
    </div>
</div>

@include('layouts.inc.message')


<div id="content">
    <table id="datatableid" class="table table-bordered table-dark">
        <thead>
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Contact</th>
                <th class="text-center">Date Added</th>
                <th class="text-center">Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedbacks as $feedback)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $feedback->name }}</td>
                    <td>{{ $feedback->email }}</td>
                    <td>{{ $feedback->contact }}</td>
                    <td>{{ date('Y-m-d h:i:s A', strtotime($feedback->created_at)) }}</td>
                    <td class="text-center">
                        @include('admin.feedback-modal')
                        @include('reply-modal')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!--Search bar-->
<script>
    $(document).ready(function() {
        $('#datatableid').DataTable();
    });
</script>
