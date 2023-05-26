<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewMessageModal{{ $feedback->id }}">
    @if ($feedback->isRead == false && $feedback->replied_at == null)
        <i class="fa fa-envelope"></i>
    @elseif($feedback->replied_at != null || $feedback->isRead == true)
        <i class="fa fa-envelope-open"></i>
    @endif
</button>

<div class="modal fade" id="viewMessageModal{{ $feedback->id }}" data-backdrop="static" style="color: black;" data-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">MESSAGE</h5>
                <a style="cursor: pointer;" data-dismiss="modal"><i class="fa fa-xmark"></i></a>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                    <button type="submit" class="btn btn-success">
                        @if ($feedback->isRead == false)
                            MARK AS READ
                        @else
                            MARK AS UNREAD
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
