<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SalesRepresentative;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SalesRepresentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales_representatives = SalesRepresentative::latest('id');
        if ($request->search) {
            $sales_representatives = $sales_representatives->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')->orWhere('phone', 'like', '%' . $request->search . '%')->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        $sales_representatives = $sales_representatives->paginate($request->per_page ?? 10);
        return response()->json([
            'status'  => true,
            'message' => 'Sales representative retreived successfully.',
            'data'    => $sales_representatives,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'    => 'sometimes|image|mimes:png,jpg|max:10240',
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:15',
            'email'    => 'required|email',
            'location' => 'required|string',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $secret_key                        = 'SL' . rand(1000, 9999);
        $sales_representatives             = new SalesRepresentative();
        $sales_representatives->name       = $request->name;
        $sales_representatives->secret_key = $secret_key;
        $sales_representatives->phone      = $request->phone;
        $sales_representatives->email      = $request->email;
        $sales_representatives->location   = $request->location;

        if ($request->has('photo')) {
            $image      = $request->file('photo');
            $final_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/representative'), $final_name);
            $sales_representatives->photo = $final_name;
        } else {
            $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($request->name) . '&background=random&bold=true&size=256';
            $response  = Http::get($avatarUrl);
            $filename  = time() . '.png';
            $savePath  = public_path('uploads/representative/' . $filename);
            file_put_contents($savePath, $response->body());
            $sales_representatives->photo = $filename;
        }

        $sales_representatives->save();
        return response()->json([
            'status'  => true,
            'message' => 'Sales representative created successfully.',
            'data'    => $sales_representatives,
        ], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sales_representative = SalesRepresentative::with('users:id,sales_representative_id,channel_name,avatar,created_at')
            ->findOrFail($id);

        foreach ($sales_representative->users as $user) {
            $user->created_at_date_formatted = $user->created_at ? $user->created_at->format('d M Y') : null;
            $user->created_at_time_formatted = $user->created_at ? $user->created_at->format(' h:i A') : null;
        }

        return response()->json([
            'status'  => true,
            'message' => 'Sales representative detail retrieved successfully.',
            'data'    => $sales_representative,
        ], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sales_representative = SalesRepresentative::findOrFail($id);
            if ($sales_representative) {
                $has_user = $sales_representative->users()->count();
                if ($has_user) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'You cannot delete this sales representative. There are related users.',
                        'data'    => null,
                    ], 200);
                }
            }
            if ($sales_representative) {
                $photo_location     = public_path('uploads/representative');
                $old_photo          = basename($sales_representative->photo);
                $old_photo_location = $photo_location . '/' . $old_photo;
                if (file_exists($old_photo_location)) {
                    unlink($old_photo_location);
                }
            }
            $sales_representative->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Sales representative deleted successfully.',
                'data'    => $sales_representative,
            ], 200);
        } catch (Exception $e) {
            Log::error('Sales representative deleted error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
}
