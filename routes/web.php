<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('', [HomeController::class, 'homePage'])->name('homePage');
    Route::get('about', [HomeController::class, 'aboutPage'])->name('aboutPage');
    Route::get('faq', [HomeController::class, 'faqPage'])->name('faqPage');
    Route::get('volunteer', [HomeController::class, 'volunteerPage'])->name('volunteerPage');
    Route::get('gallery', [HomeController::class, 'galleryPage'])->name('galleryPage');
    Route::get('blog', [HomeController::class, 'blogPage'])->name('blogPage');
    Route::get('blog-details/{id}', [HomeController::class, 'singleBlogPage'])->name('singleBlogPage');
    Route::post('comment', [HomeController::class, 'submitComment'])->name('submitComment');
    Route::post('reply', [HomeController::class, 'submitReply'])->name('submitReply');
    Route::get('event', [HomeController::class, 'eventPage'])->name('eventPage');
    Route::get('event-details/{slug}', [HomeController::class, 'singleEventPage'])->name('singleEventPage');
    Route::post('subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
    Route::get('subscriber/verify/{token}/{email}', [HomeController::class, 'subscriberVerification'])->name('subscriberVerification');
    Route::get('contact', [HomeController::class, 'contactPage'])->name('contactPage');
    Route::post('contact', [HomeController::class, 'contactSubmit'])->name('contactSubmit');
    Route::get('user/event/ticket',[HomeController::class,'userEventTicket'])->name('userEventTicket');
    Route::get('user/event/ticket/invoice/{id}',[HomeController::class,'userEventTicketInvoice'])->name('userEventTicketInvoice');
    Route::get('cause', [HomeController::class, 'causePage'])->name('causePage');
    Route::get('cause-details/{slug}', [HomeController::class, 'singleCausePage'])->name('singleCausePage');
    Route::get('user/cause/donation',[HomeController::class,'userCauseDonation'])->name('userCauseDonation');
    Route::get('user/cause/donation/invoice/{id}',[HomeController::class,'userCauseDonationInvoice'])->name('userCauseDonationInvoice');

    // event_ticket_payment
    Route::post('event/ticket/free/payment', [PaymentController::class, 'eventFreePayment'])->name('eventFreePayment');
    Route::post('event/ticket/payment', [PaymentController::class, 'eventPayment'])->name('eventPayment');
    Route::get('event/ticket/paypal-success', [PaymentController::class, 'eventPaypalSuccess'])->name('eventPaypalSuccess');
    Route::get('event/ticket/cancel', [PaymentController::class, 'eventPaymentCancel'])->name('eventPaymentCancel');
    Route::get('event/ticket/stripe-success', [PaymentController::class, 'eventStripeSuccess'])->name('eventStripeSuccess');

    // cause_payment
    Route::post('cause/payment', [PaymentController::class, 'causePayment'])->name('causePayment');
    Route::get('cause/paypal-success', [PaymentController::class, 'causePaypalSuccess'])->name('causePaypalSuccess');
    Route::get('cause/cancel', [PaymentController::class, 'causePaymentCancel'])->name('causePaymentCancel');
    Route::get('cause/stripe-success', [PaymentController::class, 'causeStripeSuccess'])->name('causeStripeSuccess');

    //other pages
    Route::get('terms_condition', [HomeController::class, 'termsCondition'])->name('termsCondition');
    Route::get('privacy_policy', [HomeController::class, 'privacyPolicy'])->name('privacyPolicy');

});

require 'auth.php';
require 'admin.php';
