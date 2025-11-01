<?php

namespace App\Http\Controllers\Backend\Export;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserExportController extends Controller
{
    public function exportPDF(Request $request)
    {
        $search = $request->search;
        $users = User::with('role:id,name')
            ->latest('id')
            ->whereNotIn('id', [1, 2])
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhereHas('role', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->get();
        $generalSetting = GeneralSetting::find(1);
        $site_logo = $generalSetting->site_logo;
        $site_name = $generalSetting->site_name ?? config('app.name');
        $pdf = Pdf::loadView('backend.pages.export.user_list_pdf', compact('users', 'site_logo', 'site_name'));
        return $pdf->setPaper('a4', 'portrait')->download('user_list.pdf');
    }

    public function exportExcel(Request $request)
    {
        $search = $request->search;
        return Excel::download(new UsersExport($search), 'user_list.xlsx');
    }
}
