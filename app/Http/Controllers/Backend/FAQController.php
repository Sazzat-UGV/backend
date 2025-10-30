<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = FAQ::all();
        return response()->json([
            'status'  => true,
            'message' => 'FAQ retreived successfully.',
            'data'    => $faqs,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $faq = FAQ::create([
            'question' => $request->question,
            'answer'   => $request->answer,
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'Faq created successfully.',
            'data'    => $faq,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            $faq           = FAQ::findOrFail($id);
            $faq->question = $request->question;
            $faq->answer   = $request->answer;
            $faq->save();

            return response()->json([
                'status'  => true,
                'message' => 'Faq updated successfully.',
                'data'    => $faq,
            ], 200);
        } catch (Exception $e) {
            Log::error('Faq updated error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            $faq->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Faq deleted successfully.',
                'data'    => $faq,
            ], 200);
        } catch (Exception $e) {
            Log::error('Faq deleted error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
}
