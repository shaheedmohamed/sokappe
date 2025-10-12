<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Auth::user()->portfolios()->latest()->paginate(12);
        return view('portfolio.index', compact('portfolios'));
    }

    public function create()
    {
        return view('portfolio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'category' => 'required|string',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:50',
            'project_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('portfolio', 'public');
                $imagePaths[] = $path;
            }
        }

        $portfolio = Auth::user()->portfolios()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'technologies' => $validated['technologies'] ?? [],
            'project_url' => $validated['project_url'],
            'github_url' => $validated['github_url'],
            'images' => $imagePaths,
            'completion_date' => $validated['completion_date'],
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        return redirect()->route('portfolio.index')->with('success', '✅ تم إضافة العمل إلى معرض الأعمال بنجاح');
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->incrementViews();
        return view('portfolio.show', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);
        return view('portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'category' => 'required|string',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:50',
            'project_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'new_images' => 'nullable|array|max:5',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable|array',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        // Handle existing images
        $existingImages = $validated['existing_images'] ?? [];
        
        // Delete removed images
        if ($portfolio->images) {
            foreach ($portfolio->images as $image) {
                if (!in_array($image, $existingImages)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        // Handle new image uploads
        $imagePaths = $existingImages;
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('portfolio', 'public');
                $imagePaths[] = $path;
            }
        }

        $portfolio->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'technologies' => $validated['technologies'] ?? [],
            'project_url' => $validated['project_url'],
            'github_url' => $validated['github_url'],
            'images' => $imagePaths,
            'completion_date' => $validated['completion_date'],
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        return redirect()->route('portfolio.index')->with('success', '✅ تم تحديث العمل بنجاح');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);

        // Delete images
        if ($portfolio->images) {
            foreach ($portfolio->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $portfolio->delete();

        return redirect()->route('portfolio.index')->with('success', '✅ تم حذف العمل بنجاح');
    }
}
