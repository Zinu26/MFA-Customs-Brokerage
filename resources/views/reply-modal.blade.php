<button class="btn btn-primary" data-toggle="modal" data-target="#replyModal{{$feedback->id}}"><i class="fa fa-reply"></i></button>

<!--Archive modal-->
<div class="modal fade" id="replyModal{{$feedback->id}}" data-backdrop="static" style="color: black;" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">REPLY</h5>
                <a style="cursor: pointer;" data-dismiss="modal"><i class="fa fa-xmark"></i></a>
            </div>
      <form action="@if (Auth::user()->type == 'admin'){{ route('admin.feedback.reply', $feedback->id) }} @elseif(Auth::user()->type == 'employee'){{ route('employee.feedback.reply', $feedback->id) }} @endif" method="post">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <textarea name="reply" rows="4" cols="50" placeholder="Enter your reply"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
          <button type="submit" class="btn btn-primary">SUBMIT REPLY</button>
        </div>
       </form>
    </div>
  </div>
</div>
