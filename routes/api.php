<?php

use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\api\Frontend\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChannelController;
use App\Http\Controllers\Backend\CityandStateController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FAQController;
use App\Http\Controllers\Backend\PricingController;
use App\Http\Controllers\Backend\PromotionalBanner;
use App\Http\Controllers\Backend\SalesRepresentativeController;
use App\Http\Controllers\Backend\SEOController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Frontend\AppealController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\CommentReplyController;
use App\Http\Controllers\Frontend\DashboardController as FrontendDashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LikedandDislikedController;
use App\Http\Controllers\Frontend\ReportController;
use App\Http\Controllers\Frontend\StripePaymentController;
use App\Http\Controllers\Frontend\VideoController;
use App\Http\Controllers\Frontend\WatchHistoryController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api'], function ($router) {

    Route::prefix('auth/')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('social-login', [AuthController::class, 'socialLogin']);
        Route::post('otp-verification', [AuthController::class, 'otpVerify']);
        Route::get('check-token', [AuthController::class, 'validateToken']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forget-password', [AuthController::class, 'forgetPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });

    Route::middleware(['auth:api', 'verified.user'])->prefix('/')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('edit-profile', [AuthController::class, 'editProfile']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('logout', [AuthController::class, 'logout']);

        // user routes
        Route::middleware('user')->as('user')->group(function () {
            Route::resource('faqs', FAQController::class);
            Route::resource('watch-history', WatchHistoryController::class);
            Route::resource('videos', VideoController::class)->except('show');
            // Route::resource('comments', CommentController::class);
            // Route::resource('replies', CommentReplyController::class);
            Route::post('pause-play-watch-history', [WatchHistoryController::class, 'pausePlayWatchHistory']);
            Route::delete('bulk-delete-watch-history', [WatchHistoryController::class, 'bulkDeleteWatchHistory']);
            Route::post('videos/bulk-delete', [VideoController::class, 'bulkDelete']);
            Route::post('add_like_dislike', [LikedandDislikedController::class, 'addLikeDislike']);
            Route::get('like_videos', [LikedandDislikedController::class, 'getLikeVideos']);
            Route::delete('like_videos/{id}', [LikedandDislikedController::class, 'deleteLikeVideos']);
            Route::post('videos/change-visibility/{id}', [VideoController::class, 'changeVisibility']);
            Route::post('send-message', [SettingController::class, 'sendMessage']);
            Route::get('dashboard', FrontendDashboardController::class);
            Route::get('video-analytics/{id}', [VideoController::class, 'videoAnalytics']);
            Route::get('analytics', [AnalyticsController::class, 'analytics']);
            Route::post('add-remove-comment-reaction', [CommentController::class, 'addOrRemoveCommentReaction']);
            Route::post('add-remove-reply-reaction', [CommentReplyController::class, 'addOrRemoveReplyReaction']);
            Route::post('add-report', [ReportController::class, 'addReport']);
            Route::get('get-reports', [ReportController::class, 'getReport']);
            Route::post('add-appeal', [AppealController::class, 'addAppeal']);

            Route::post('payment-success', [StripePaymentController::class, 'paymentSuccess']);
        });

        // admin routes
        Route::middleware('admin')->prefix('admin/')->as('admin')->group(function () {
            Route::put('about-us/{id}', [SettingController::class, 'updateAboutUs']);
            Route::post('page', [SettingController::class, 'createOrUpdatePage']);
            Route::post('contact', [SettingController::class, 'updateContact']);
            Route::post('update-price', [PricingController::class, 'updatePrice']);
            Route::post('update-seo', [SEOController::class, 'updateSeo']);
            Route::post('update-banner-status/{id}', [PromotionalBanner::class, 'toggleBannerStatus']);
            Route::post('update-system-setting', [SystemSettingController::class, 'toggleSystemBannerStatus']);
            Route::get('transactions', [TransactionController::class, 'transactions']);
            Route::get('dashboard', DashboardController::class);
            Route::get('get-reports', [ReportController::class, 'getAdminReport']);
            Route::get('get-appeals', [AppealController::class, 'getAdminAppeal']);
            Route::get('get-appeal-details/{id}', [AppealController::class, 'getAppealDetails']);
            Route::post('take-appeal-action/{id}', [AppealController::class, 'takeAppealAction']);
            Route::post('take-report-action/{id}', [ReportController::class, 'takeReportAction']);
            Route::delete('report-delete/{id}', [ReportController::class, 'reportDelete']);
            Route::delete('appeal-delete/{id}', [AppealController::class, 'appealDelete']);

            Route::resource('categories', CategoryController::class)->except('index', 'show');
            Route::resource('faqs', FAQController::class);
            Route::resource('blogs', BlogController::class);
            Route::resource('banners', PromotionalBanner::class)->except('index');
            Route::resource('sales-representatives', SalesRepresentativeController::class);

            Route::get('get-channels', [ChannelController::class, 'getChannels']);

            Route::delete('delete-channel/{id}', [ChannelController::class, 'deleteChannel']);
        });

        // common routes
        Route::middleware('admin.user')->as('common')->group(function () {
            Route::get('notifications', [NotificationController::class, 'notifications']);
            Route::post('mark-notification/{id}', [NotificationController::class, 'singleMark']);
            Route::post('mark-all-notification', [NotificationController::class, 'allMark']);

            Route::resource('comments', CommentController::class);
            Route::resource('replies', CommentReplyController::class);
            Route::get('about-us', [SettingController::class, 'getAboutUs']);
            Route::get('get-report-detail/{id}', [ReportController::class, 'getReportDetail']);

        });
    });

    // token free routes
    Route::get('contact', [SettingController::class, 'getContact']);
    Route::get('page', [SettingController::class, 'getPage']);
    Route::resource('categories', CategoryController::class)->only('index');
    Route::resource('videos', VideoController::class)->only('show');
    Route::resource('blogs', BlogController::class)->only('index', 'show');
    Route::get('get-price', [PricingController::class, 'getPrice']);
    Route::get('get-seo', [SEOController::class, 'getSeo']);
    Route::resource('banners', PromotionalBanner::class)->only('index');
    Route::get('get-promotional-video', [HomeController::class, 'getPromotionalVideo']);
    Route::get('promotional-video-with-limitation', [HomeController::class, 'promotionalVideoWithLimitation']);
    Route::get('promotional-video-with-pagination', [HomeController::class, 'promotionalVideoWithPagination']);
    Route::get('get-related-video/{id}', [HomeController::class, 'getRelatedVideo']);
    Route::get('get-promoted-related-video/{id}', [HomeController::class, 'getPromotedRelatedVideo']);
    Route::get('search-video', [HomeController::class, 'searchVideo']);
    Route::get('home-video', [HomeController::class, 'homeVideo']);
    Route::get('all-videos', [HomeController::class, 'allVideo']);
    Route::get('states', [CityandStateController::class, 'states']);
    Route::get('cities/{state_id}', [CityandStateController::class, 'city']);
    Route::get('channel-details/{id}', [ChannelController::class, 'getChannelDetails']);
    Route::post('payment-intent', [StripePaymentController::class, 'paymentIntent']);
    Route::get('global-search-videos', [VideoController::class, 'globalSearchVideos']);
});
