<?php
namespace App\Http\Controllers\Frontend;

use Exception;
use Stripe\Stripe;
use App\Models\User;
use Stripe\PaymentIntent;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StripePaymentController extends Controller
{
    public function paymentIntent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason'         => 'required|string|in:Uploading video,Promoting YouTube Link,Onsite account creation',
            'amount'         => 'required',
            'payment_method' => 'required',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $paymentIntent = PaymentIntent::create([
                'amount'         => $request->amount * 100,
                'currency'       => 'usd',
                'payment_method' => $request->payment_method,
                'metadata'       => [
                    'service_name' => $request->reason,
                ],
            ]);
            return response()->json([
                'data' => $paymentIntent,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason'            => 'required|string|in:Uploading video,Promoting YouTube Link,Onsite account creation',
            'user_id'            => 'required',
            'amount'            => 'required',
            'payment_intent_id' => 'required',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        if($request->reason=='Onsite account creation'){
            $user=User::find($request->user_id);
            $user->is_pay=1;
            $user->save();
        }
        $payment = Transactions::create([
            'user_id'           => $request->user_id,
            'reason'            => $request->reason,
            'amount'            => $request->amount,
            'payment_intent_id' => $request->payment_intent_id,
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'Payment information stored successfully.',
            'data'    => $payment,
        ], 200);
    }
}
