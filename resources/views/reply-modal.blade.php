<button class="btn btn-primary" data-toggle="modal" data-target="#replyModal{{$feedback->id}}"><i class="fa fa-reply"></i></button>

<!--Archive modal-->
<div class="modal fade" id="replyModal{{$feedback->id}}" data-backdrop="static" style="color: black;" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
      </div>
      <form action="@if (Auth::user()->type == 'admin'){{ route('admin.feedback.reply', $feedback->id) }} @elseif(Auth::user()->type == 'employee'){{ route('employee.feedback.reply', $feedback->id) }} @endif" method="post">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <textarea name="reply" rows="4" cols="50" placeholder="Enter your reply"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit Reply</button>
        </div>
       </form>
    </div>
  </div>
</div>
