<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transactions(Request $request)
    {
        $earned_this_month = Transactions::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
        $transactions = Transactions::with('user:id,channel_name,avatar')->latest('id');
        if ($request->search) {
            $transactions = $transactions->where(function ($q) use ($request) {
                $q->where('reason', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('channel_name', 'like', '%' . $request->search . '%');
                    });
            });
        }
        $transactions = $transactions->paginate($request->per_page ?? 10);
        $data         = [
            'earned_this_month' => round($earned_this_month, 2),
            'transactions'      => $transactions,
        ];
        return response()->json([
            'status'  => true,
            'message' => 'Transactions retreived successfully.',
            'data'    => $data,
        ], 200);
    }
}
