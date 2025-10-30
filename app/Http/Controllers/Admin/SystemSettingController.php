<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;

class SystemSettingController extends Controller
{
    public function toggleSystemBannerStatus()
    {
        $systemSetting = SystemSetting::find(1);
        if (! $systemSetting) {
            return response()->json([
                'status'  => false,
                'message' => 'System Setting not found.',
            ], 404);
        }

        $systemSetting->is_banner_active = ! $systemSetting->is_banner_active;
        $systemSetting->save();

        return response()->json([
            'status'  => true,
            'message' => "System setting status has been changed successfully.",
            'data'    => $systemSetting,
        ], 200);
    }
}
