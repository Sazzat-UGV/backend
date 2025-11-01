<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        $setting = null;
        $keywords = '';

        try {
            $setting = GeneralSetting::where('id', 1)->first();

            if ($setting) {
                $jsonString = $setting->site_keywords;
                $data = json_decode($jsonString, true);
                if (is_array($data)) {
                    $keywords = implode(',', array_column($data, 'value'));
                }
            }
        } catch (\Exception $e) {
            Log::error("GeneralSetting table not found or other error: " . $e->getMessage());
        }

        View::share([
            'setting' => $setting,
            'keywords' => $keywords,
        ]);
    }

}
