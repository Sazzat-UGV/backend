<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Image;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('browse-event');
        $events = Event::latest('id');
        if ($request->search) {
            $events = $events->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $events = $events->paginate(10);
        return view('backend.pages.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-event');
        return view('backend.pages.event.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-event');
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'total_seat' => 'nullable|numeric',
            'booked_seat' => 'nullable|numeric',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:10240',
        ]);
        $event = Event::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'email' => $request->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'map' => $request->map,
            'price' => $request->price,
            'total_seat' => $request->total_seat,
            'booked_seat' => $request->booked_seat,
        ]);
        $this->image_upload($request, $event->id);
        return redirect()->route('admin.event.index')->with('success', 'Event added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('read-event');
        $event = Event::findOrFail($id);
        return view('backend.pages.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('edit-event');
        $event = Event::findOrFail($id);
        return view('backend.pages.event.edit', compact('event'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-event');
        $event = Event::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'total_seat' => 'nullable|numeric',
            'booked_seat' => 'nullable|numeric',
            'photo' => 'sometimes|image|mimes:png,jpg,jpeg|max:10240',
        ]);
        $event->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'email' => $request->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'map' => $request->map,
            'price' => $request->price,
            'total_seat' => $request->total_seat,
            'booked_seat' => $request->booked_seat,
        ]);
        $this->image_upload($request, $event->id);
        return redirect()->route('admin.event.index')->with('success', 'Event updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-event');
        $event = Event::findOrFail($id);
        if ($event->featured_photo != 'default-event.png') {
            //delete old photo
            $photo_location = 'public/uploads/event/';
            $old_photo_location = $photo_location . $event->featured_photo;
            unlink(base_path($old_photo_location));
        }
        $event->delete();
        return redirect()->route('admin.event.index')->with('success', 'Event deleted successfully.');
    }

    public function image_upload($request, $event_id)
    {
        $event = Event::findOrFail($event_id);
        if ($request->hasFile('photo')) {
            if ($event->featured_photo != 'default-event.png') {
                //delete old photo
                $photo_location = 'public/uploads/event/';
                $old_photo_location = $photo_location . $event->featured_photo;
                unlink(base_path($old_photo_location));
            }
            $photo_loation = 'public/uploads/event/';
            $uploaded_photo = $request->file('photo');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->save(base_path($new_photo_location));
            $check = $event->update([
                'featured_photo' => $new_photo_name,
            ]);
        }
    }

    public function eventTicketPage($id)
    {
        Gate::authorize('event-ticket');
        $eventTicket = EventTicket::with('user')->where('event_id', $id)->where('payment_status', 'COMPLETED')->latest('id')->get();
        return view('backend.pages.event.event_ticket', compact('eventTicket'));
    }

    public function eventTicketInvoice($id)
    {
        Gate::authorize('event-ticket');
        $TicketInvoice = EventTicket::with('user', 'event')->where('id', $id)->first();
        $billed_to = User::where('id', 1)->first();
        return view('backend.pages.event.event_ticket_invoice', compact('TicketInvoice', 'billed_to'));
    }
}
