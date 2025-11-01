<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\SubscriberMail;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{

    public function index()
    {
        Gate::authorize('browse-subscriber');
        $subscribers = Subscriber::where('status', 1)->latest('id')->select('id', 'email', 'created_at')->paginate();
        return view('backend.pages.subscriber.index', compact('subscribers'));
    }

    public function sendMessagePage()
    {
        Gate::authorize('send-message-to-all');
        return view('backend.pages.subscriber.send_message');
    }
    public function sendMessage(Request $request)
    {
        Gate::authorize('send-message-to-all');
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $subject = $request->subject;
        $content = $request->content;
        $subscribers = Subscriber::where('status', 1)->select('id', 'email')->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new SubscriberMail($subject, $content));
        }
        return redirect()->back()->with('success', 'Message sent to all subscribers.');
    }

    public function destroy($id)
    {
        Gate::authorize('delete-subscriber');
        $subscriber = Subscriber::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Subscriber deleted successfully.');
    }

}
