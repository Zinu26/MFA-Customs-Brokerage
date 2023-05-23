<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewMessageModal{{ $feedback->id }}">
    @if ($feedback->isRead == false)
    <i class="fa fa-envelope"></i>@else<i class="fa fa-envelope-open"></i>
    @endif
</button>

<div class="modal fade" id="viewMessageModal{{ $feedback->id }}" data-backdrop="static" data-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel" style="color:black">Message</h1>
            </div>
            <form
                action="@if (Auth::user()->type == 'admin')
                            @if ($feedback->isRead == false){{ route('admin.read', $feedback->id) }}
                            @else {{ route('admin.unread', $feedback->id) }}
                            @endif
                        @else
                            @if ($feedback->isRead == false) {{ route('employee.read', $feedback->id) }}
                            @else {{ route('employee.unread', $feedback->id) }}
                            @endif
                        @endif"
                method="POST">
                @csrf
                <div class="modal-body">
                    <p style="color:black;"> {{ $feedback->message }} </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        @if ($feedback->isRead == false)
                            Mark as Read
                        @else
                            Mark as Unread
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
