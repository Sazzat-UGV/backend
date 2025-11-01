<?php

namespace App\Http\Controllers;

use App\Models\Cause;
use App\Models\CauseDonation;
use App\Models\Event;
use App\Models\EventTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function eventPayment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $request->validate([
            'event_id' => 'required|numeric',
            'price' => 'required|numeric',
            'number_of_tickets' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);
        $user_id = Auth::user()->id;

        $event = Event::where('id', $request->event_id)->first();
        if ($event->total_seat > 0) {
            $remaining_seat = $event->total_seat - $event->booked_seat;
            if ($event->booked_seat + $request->number_of_tickets > $event->total_seat) {
                return back()->with('error', 'Sorry, only ' . $remaining_seat . ' seats are available.');
            }
        }

        $total_price = $request->number_of_tickets * $request->price;
        if ($request->payment_method == 'paypal') {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('eventPaypalSuccess'),
                    "cancel_url" => route('eventPaymentCancel'),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $total_price,
                        ],
                    ],
                ],
            ]);
            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        session()->put('event_id', $request->event_id);
                        session()->put('user_id', $user_id);
                        session()->put('price', $request->price);
                        session()->put('number_of_tickets', $request->number_of_tickets);
                        session()->put('total_price', $total_price);
                        return redirect()->away($link['href']);
                    }
                }
            } else {
                return redirect()->route('eventPaymentCancel');
            }
        }
        if ($request->payment_method == 'stripe') {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'USD',
                            'product_data' => [
                                'name' => $event->name,
                            ],
                            'unit_amount' => $total_price * 100,
                        ],
                        'quantity' => $request->number_of_tickets,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('eventStripeSuccess') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('eventPaymentCancel'),
            ]);
            if (isset($response->id) && $response->id != '') {
                session()->put('event_id', $request->event_id);
                session()->put('user_id', $user_id);
                session()->put('price', $request->price);
                session()->put('number_of_tickets', $request->number_of_tickets);
                session()->put('total_price', $total_price);
                return redirect($response->url);
            } else {
                return redirect()->route('eventPaymentCancel');
            }
        }

    }

    public function eventPaypalSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $payment = new EventTicket;
            $payment->payment_id = $response['id'];
            $payment->event_id = session()->get('event_id');
            $payment->user_id = session()->get('user_id');
            $payment->unit_price = session()->get('price');
            $payment->number_of_tickets = session()->get('number_of_tickets');
            $payment->total_price = session()->get('total_price');
            $payment->payment_method = "PayPal";
            $payment->payment_status = $response['status'];
            $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            $payment->save();

            unset($_SESSION['event_id']);
            unset($_SESSION['user_id']);
            unset($_SESSION['price']);
            unset($_SESSION['number_of_tickets']);
            unset($_SESSION['total_price']);
            $event = Event::where('id', session()->get('event_id'))->first();
            $event->booked_seat = $event->booked_seat + session()->get('number_of_tickets');
            $event->save();
            return redirect()->route('singleEventPage', $event->slug)->with('success', 'Payment is successfully.');

        } else {
            return redirect()->route('eventPaymentCancel');
        }
    }
    public function eventPaymentCancel()
    {
        return redirect()->route('homePage')->with('error', 'Payment is cancelled.');
    }

    public function eventStripeSuccess(Request $request)
    {
        if (isset($request->session_id)) {

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            $payment = new EventTicket;
            $payment->payment_id = $response->id;
            $payment->event_id = session()->get('event_id');
            $payment->user_id = session()->get('user_id');
            $payment->unit_price = session()->get('price');
            $payment->number_of_tickets = session()->get('number_of_tickets');
            $payment->total_price = session()->get('total_price');
            $payment->payment_method = "Stripe";
            $payment->payment_status = 'COMPLETED';
            $payment->currency = 'USD';
            $payment->save();

            $event = Event::where('id', session()->get('event_id'))->first();
            $event->booked_seat = $event->booked_seat + session()->get('number_of_tickets');
            $event->save();
            return redirect()->route('singleEventPage', $event->slug)->with('success', 'Payment is successfully.');
            session()->forget('event_id');
            session()->forget('user_id');
            session()->forget('price');
            session()->forget('number_of_tickets');
            session()->forget('total_price');

        } else {
            return redirect()->route('eventPaymentCancel');
        }

    }

    public function eventFreePayment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $request->validate([
            'event_id' => 'required|numeric',
            'price' => 'required|numeric',
            'number_of_tickets' => 'required|numeric',
        ]);
        $user_id = Auth::user()->id;

        $event = Event::where('id', $request->event_id)->first();
        if ($event->total_seat > 0) {
            $remaining_seat = $event->total_seat - $event->booked_seat;
            if ($event->booked_seat + $request->number_of_tickets > $event->total_seat) {
                return back()->with('error', 'Sorry, only ' . $remaining_seat . ' seats are available.');
            }
        }
        $total_price = $request->number_of_tickets * $request->price;
        $payment = new EventTicket;
        $payment->payment_id = time();
        $payment->event_id = $request->event_id;
        $payment->user_id = Auth::user()->id;
        $payment->unit_price = $request->price;
        $payment->number_of_tickets = $request->number_of_tickets;
        $payment->total_price = $total_price;
        $payment->payment_method = "Free";
        $payment->payment_status = 'COMPLETED';
        $payment->save();

        $event = Event::where('id', $request->event_id)->first();
        $event->booked_seat = $event->booked_seat + $request->number_of_tickets;
        $event->save();
        return redirect()->route('singleEventPage', $event->slug)->with('success', 'Booking is successfully.');
    }

    public function causePayment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $request->validate([
            'cause_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);
        $user_id = Auth::user()->id;

        $cause = Cause::where('id', $request->cause_id)->first();
        $remaining = $cause->goal - $cause->raised;
        if ($request->amount > $remaining) {
            return back()->with('error', 'Sorry, only ' . $remaining . '$ are needed.');
        }

        if ($request->payment_method == 'paypal') {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('causePaypalSuccess'),
                    "cancel_url" => route('causePaymentCancel'),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $request->amount,
                        ],
                    ],
                ],
            ]);
            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        session()->put('cause_id', $request->cause_id);
                        session()->put('user_id', $user_id);
                        session()->put('amount', $request->amount);
                        return redirect()->away($link['href']);
                    }
                }
            } else {
                return redirect()->route('causePaymentCancel');
            }
        }
        if ($request->payment_method == 'stripe') {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'USD',
                            'product_data' => [
                                'name' => $cause->name,
                            ],
                            'unit_amount' => $request->amount * 100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('causeStripeSuccess') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('causePaymentCancel'),
            ]);
            if (isset($response->id) && $response->id != '') {
                session()->put('cause_id', $request->cause_id);
                session()->put('user_id', $user_id);
                session()->put('amount', $request->amount);
                return redirect($response->url);
            } else {
                return redirect()->route('causePaymentCancel');
            }
        }

    }

    public function causePaypalSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $payment = new CauseDonation();
            $payment->payment_id = $response['id'];
            $payment->cause_id = session()->get('cause_id');
            $payment->user_id = session()->get('user_id');
            $payment->amount = session()->get('amount');
            $payment->payment_method = "PayPal";
            $payment->payment_status = $response['status'];
            $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            $payment->save();

            unset($_SESSION['cause_id']);
            unset($_SESSION['user_id']);
            unset($_SESSION['amount']);
            $cause = Cause::where('id', session()->get('cause_id'))->first();
            $cause->raised = $cause->raised + session()->get('amount');
            $cause->save();
            return redirect()->route('singleCausePage', $cause->slug)->with('success', 'Payment is successfully.');

        } else {
            return redirect()->route('causePaymentCancel');
        }
    }

    public function causePaymentCancel()
    {
        return redirect()->route('homePage')->with('error', 'Payment is cancelled.');
    }
    public function causeStripeSuccess(Request $request)
    {
        if (isset($request->session_id)) {

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            $payment = new CauseDonation();
            $payment->payment_id = $response->id;
            $payment->cause_id = session()->get('cause_id');
            $payment->user_id = session()->get('user_id');
            $payment->amount = session()->get('amount');
            $payment->payment_method = "Stripe";
            $payment->payment_status = 'COMPLETED';
            $payment->currency = 'USD';
            $payment->save();

            $cause = Cause::where('id', session()->get('cause_id'))->first();
            $cause->raised = $cause->raised + session()->get('amount');
            $cause->save();
            return redirect()->route('singleCausePage', $cause->slug)->with('success', 'Payment is successfully.');
            session()->forget('cause_id');
            session()->forget('user_id');
            session()->forget('amount');
        } else {
            return redirect()->route('causePaymentCancel');
        }
    }
}
