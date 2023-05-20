<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function sendFeedback(Request $request)
    {
        $feedback = new Feedback;

        $feedback->name = $request->input('name');
        $feedback->email = $request->input('email');
        $feedback->contact = $request->input('contact');
        $feedback->message = $request->input('message');
        $feedback->read_at = null;
        $feedback->save();

        return redirect()->back();
    }

    public function index(){
        $feedbacks = Feedback::all();

        return view('admin.feedback', compact('feedbacks'));
    }

    public function read($id){
        $feedback = Feedback::findOrFail($id);

        $feedback->user_id = Auth::user()->id;
        $feedback->isRead = true;
        $feedback->read_at = now();
        $feedback->save();

        return redirect()->back()->with('success', "Mark as read");
    }

    public function unread($id){
        $feedback = Feedback::findOrFail($id);

        $feedback->user_id = Auth::user()->id;
        $feedback->isRead = false;
        $feedback->read_at = null;
        $feedback->save();

        return redirect()->back()->with('success', "Mark as unread");
    }
}
