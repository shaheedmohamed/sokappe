<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    public function index()
    {
        $offers = Deal::where('type', 'offer')->where('status', 'active')->latest()->get();
        $requests = Deal::where('type', 'request')->where('status', 'active')->latest()->get();
        
        return view('deals.index', compact('offers', 'requests'));
    }

    public function create()
    {
        return view('deals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:offer,request',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('deals', 'public');
                $images[] = $path;
            }
        }

        Deal::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'price' => $validated['price'],
            'type' => $validated['type'],
            'status' => 'active',
            'images' => $images,
        ]);

        return redirect()->route('deals.index')->with('success', 'تم نشر الصفقة بنجاح!');
    }

    public function show(Deal $deal)
    {
        return view('deals.show', compact('deal'));
    }
}
