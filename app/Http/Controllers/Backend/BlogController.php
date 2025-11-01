<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\SubscriberMail;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('browse-blog');
        $blogs = Blog::with(['category'])
            ->withCount('comments')
            ->latest('id')
            ->paginate(10);
        return view('backend.pages.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-blog');
        $categories = Category::latest('id')->get();
        return view('backend.pages.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-blog');

        $request->validate([
            'category' => 'required|numeric',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:10240',
        ]);

        $tagsString = '';
        if ($request->tags) {
            $tagsArray = json_decode($request->tags, true);
            $tags = array_map(function ($tag) {
                return $tag['value'];
            }, $tagsArray);
            $tagsString = implode(',', $tags);
        }

        $blog = Blog::create([
            'category_id' => $request->category,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'tags' => $tagsString,
        ]);

        $this->image_upload($request, $blog->id);
        if ($request->send_message_to_subscribers == 1) {
            $url = url('blog-details/' . $blog->id);
            $subject = 'New Post Published';
            $content = "<p style='text-align:center;'>New post has been published. Please visit our website to read the post.</p>
                        <div style='text-align: center; margin-top: 20px;'>
                             <a href='{$url}' style='
                                display: inline-block;
                                margin-top:10px;
                                background-color: #4CAF50;
                                color: #ffffff;
                                text-decoration: none;
                                padding: 12px 24px;
                                border-radius: 5px;
                                font-size: 16px;
                                font-weight: bold;'
                                target='_blank'>
                                View Post
                            </a>
                        </div>";
            $subscribers = Subscriber::where('status', 1)->select('id', 'email')->get();
            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->send(new SubscriberMail($subject, $content));
            }
        }
        return redirect()->route('admin.blog.index')->with('success', 'Blog added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('read-blog');
        $blog = Blog::with('category')->findOrFail($id);
        return view('backend.pages.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('edit-blog');
        $categories = Category::latest('id')->get();
        $blog = Blog::with('category')->findOrFail($id);
        return view('backend.pages.blog.edit', compact('categories', 'blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-blog');
        $blog = Blog::findOrFail($id);
        $request->validate([
            'category' => 'required|numeric',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'photo' => 'sometimes|image|mimes:png,jpg,jpeg|max:10240',
        ]);

        $tagsString = '';
        if ($request->tags) {
            $tagsArray = json_decode($request->tags, true);
            $tags = array_map(function ($tag) {
                return $tag['value'];
            }, $tagsArray);
            $tagsString = implode(',', $tags);
        }

        $blog->update([
            'category_id' => $request->category,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'tags' => $tagsString,
        ]);

        $this->image_upload($request, $blog->id);
        return redirect()->route('admin.blog.index')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-blog');
        $blog = Blog::findOrFail($id);
        if ($blog->photo != 'default_blog.png') {
            //delete old photo
            $photo_location = 'public/uploads/blog/';
            $old_photo_location = $photo_location . $blog->photo;
            unlink(base_path($old_photo_location));
        }
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Blog deleted successfully.');
    }

    public function image_upload($request, $blog_id)
    {
        $blog = Blog::findOrFail($blog_id);
        if ($request->hasFile('photo')) {
            if ($blog->photo != 'default_blog.png') {
                //delete old photo
                $photo_location = 'public/uploads/blog/';
                $old_photo_location = $photo_location . $blog->photo;
                unlink(base_path($old_photo_location));
            }
            $photo_loation = 'public/uploads/blog/';
            $uploaded_photo = $request->file('photo');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->save(base_path($new_photo_location));
            $check = $blog->update([
                'photo' => $new_photo_name,
            ]);
        }
    }

    public function browseComment($id)
    {
        Gate::authorize('browse-comment');
        $comments = Comment::withCount('reply')->where('blog_id', $id)->latest('id')->paginate(10);
        return view('backend.pages.blog.comment', compact('comments'));
    }

    public function deleteComment($id)
    {
        Gate::authorize('delete-comment');
        $comments = Comment::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    public function commentStatus($id)
    {
        Gate::authorize('change-comment-status');
        $comments = Comment::findOrFail($id);
        $comments->status = $comments->status == 'Accept' ? 'Pending' : 'Accept';
        $comments->save();
        return redirect()->back()->with('success', 'Status changed successfully.');
    }

    public function replyComment(Request $request)
    {
        Gate::authorize('reply-comment');
        $request->validate([
            'comment_id' => 'required|numeric',
            'reply' => 'required|string',
        ]);

        Reply::create([
            'comment_id' => $request->comment_id,
            'name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'email' => Auth::user()->email,
            'comment' => $request->reply,
            'user_type' => 'Admin',
            'status' => 'Accept',
        ]);
        return redirect()->back()->with('success', "Reply submitted successfully.");
    }

    public function browseReply($id)
    {
        Gate::authorize('browse-reply');
        $replies = Reply::where('comment_id', $id)->latest('id')->paginate(10);
        return view('backend.pages.blog.reply', compact('replies'));
    }

    public function replyStatus($id)
    {
        Gate::authorize('change-reply-status');
        $reply = Reply::findOrFail($id);
        $reply->status = $reply->status == 'Accept' ? 'Pending' : 'Accept';
        $reply->save();
        return redirect()->back()->with('success', 'Status changed successfully.');
    }

    public function deleteReply($id)
    {
        Gate::authorize('delete-reply');
        Reply::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Reply deleted successfully.');
    }
}
