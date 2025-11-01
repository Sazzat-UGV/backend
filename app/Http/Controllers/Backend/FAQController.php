<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        Gate::authorize('browse-faqs');
        $faqs = Faq::latest('id')->paginate();
        return view('backend.pages.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-faqs');
        return view('backend.pages.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-faqs');
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:2000',
        ]);
        $faq = Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return redirect()->route('admin.faqs.index')->with('success', 'Faq added successfully.');
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
        Gate::authorize('edit-faqs');
        $faq = Faq::findOrFail($id);
        return view('backend.pages.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-faqs');
        $faq = Faq::findOrFail($id);
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:2000',
        ]);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return redirect()->route('admin.faqs.index')->with('success', 'Faq updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-faqs');
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'Faq deleted successfully.');
    }

}
