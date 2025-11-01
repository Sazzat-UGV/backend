<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Cause;
use App\Models\CauseDonation;
use App\Models\Event;
use App\Models\EventTicket;
use App\Models\Role;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->hasPermission('developer-dashboard')) {
            return $this->Developerdashboard();
        } elseif (Auth::user()->hasPermission('admin-dashboard')) {
            return $this->Admindashboard();
        } elseif (Auth::user()->hasPermission('manager-dashboard')) {
            return $this->Managerdashboard();
        } else {
            return $this->Defaultdashboard();
        }
    }

    public function Developerdashboard()
    {
        $total_user = User::where('role_id', 4)->count();
        $total_admin = User::whereNotIn('role_id', [1, 4])->count();
        $role = Role::query();
        $new_register_users = User::with('role:id,name')->select('id', 'role_id', 'first_name', 'last_name', 'email', 'created_at')->latest('id')->whereNot('id', 1)->limit(5)->get();

        return view('backend.pages.dashboard.developer', compact(
            'total_user',
            'total_admin',
            'role',
            'new_register_users'
        ));
    }

    public function Admindashboard()
    {
        $total_user = User::where('role_id', 4)->whereNotNull('email_verified_at')->count();
        $total_cause = Cause::count();
        $total_event = Event::count();
        $total_testimonial = Testimonial::count();
        $total_volunteer = Volunteer::count();
        $total_subscriber = Subscriber::count();
        $total_blog = Blog::count();
        // statistics
        $monthlyData = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [
                now()->startOfYear()->addMonths($month - 1)->format('F') => [
                    'tickets' => EventTicket::whereMonth('created_at', $month)->sum('total_price'),
                    'donations' => CauseDonation::whereMonth('created_at', $month)->sum('amount'),
                ],
            ];
        });
        $ticket_booked_amount = EventTicket::sum('total_price');
        $donation_amount = CauseDonation::sum('amount');

        $new_register_users = User::with('role:id,name')->select('id', 'role_id', 'first_name', 'last_name', 'email', 'created_at')->latest('id')->whereNotIn('id', [1, 2])->limit(5)->get();
        return view('backend.pages.dashboard.admin', compact(
            'total_user',
            'total_cause',
            'total_event',
            'total_blog',
            'total_volunteer',
            'total_testimonial',
            'total_subscriber',
            'new_register_users',
            'ticket_booked_amount',
            'donation_amount',
            'monthlyData'
        ));
    }

    public function Managerdashboard()
    {
        return view('backend.pages.dashboard.manager');
    }

    public function Defaultdashboard()
    {
        $event_ticket_data = EventTicket::where('user_id', Auth::user()->id)->get();
        $cause_donation_data = CauseDonation::where('user_id', Auth::user()->id)->get();
        return view('backend.pages.dashboard.default', compact('event_ticket_data', 'cause_donation_data'));
    }

}
