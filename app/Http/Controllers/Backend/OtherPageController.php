<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OtherPage;
use Illuminate\Support\Facades\Gate;

class OtherPageController extends Controller
{
    public function termsConditionPage(){
        Gate::authorize('terms-conditions');
        $pages=OtherPage::where('id',1)->first();
        return view('backend.pages.setting.terms_condition',compact('pages'));
    }
    public function termsCondition(Request $request){
        Gate::authorize('terms-conditions');
        $pages=OtherPage::where('id',1)->first();
        $request->validate([
            'terms_condition'=>'required|string',
        ]);
        $pages->update([
            'terms_condition'=>$request->terms_condition,
        ]);
        return redirect()->back()->with('success', 'Terms & Conditions updated successfully.');
    }
    public function privacyPolicyPage(){
        Gate::authorize('privacy-policy');
        $pages=OtherPage::where('id',1)->first();
        return view('backend.pages.setting.privacy_policy',compact('pages'));
    }
    public function privacyPolicy(Request $request){
        Gate::authorize('privacy-policy');
        $request->validate([
            'privacy_policy'=>'required|string',
        ]);
        $pages=OtherPage::where('id',1)->first();
        $pages->update([
            'privacy_policy'=>$request->privacy_policy,
        ]);
        return redirect()->back()->with('success', 'Privacy Policy updated successfully.');
    }
}
