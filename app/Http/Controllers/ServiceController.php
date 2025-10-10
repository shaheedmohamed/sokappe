<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1',
            'delivery_days' => 'nullable|integer|min:1',
            'image' => 'nullable|url',
        ]);

        $data['freelancer_id'] = Auth::id();
        Service::create($data);

        return redirect('/')->with('status', 'service-created');
    }
}
