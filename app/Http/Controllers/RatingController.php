<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create(Project $project)
    {
        // Check if user is the project owner and project is completed
        if ($project->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتقييم هذا المشروع');
        }

        if ($project->status !== 'completed') {
            return redirect()->back()->with('error', 'لا يمكن تقييم المشروع إلا بعد اكتماله');
        }

        // Check if already rated
        $existingRating = Rating::where('project_id', $project->id)
            ->where('client_id', Auth::id())
            ->first();

        if ($existingRating) {
            return redirect()->back()->with('error', 'تم تقييم هذا المشروع مسبقاً');
        }

        // Get the freelancer who won the project (assuming from accepted bid)
        $acceptedBid = $project->bids()->where('status', 'accepted')->first();
        if (!$acceptedBid) {
            return redirect()->back()->with('error', 'لا يوجد محترف مقبول لهذا المشروع');
        }

        $freelancer = $acceptedBid->user;

        return view('ratings.create', compact('project', 'freelancer'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'freelancer_id' => 'required|exists:users,id',
            'communication_rating' => 'required|integer|min:1|max:5',
            'quality_rating' => 'required|integer|min:1|max:5',
            'expertise_rating' => 'required|integer|min:1|max:5',
            'delivery_rating' => 'required|integer|min:1|max:5',
            'cooperation_rating' => 'required|integer|min:1|max:5',
            'rehire_rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        // Check authorization
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if already rated
        $existingRating = Rating::where('project_id', $project->id)
            ->where('client_id', Auth::id())
            ->first();

        if ($existingRating) {
            return redirect()->back()->with('error', 'تم تقييم هذا المشروع مسبقاً');
        }

        // Calculate overall rating
        $ratings = [
            $validated['communication_rating'],
            $validated['quality_rating'],
            $validated['expertise_rating'],
            $validated['delivery_rating'],
            $validated['cooperation_rating'],
            $validated['rehire_rating']
        ];
        $overallRating = round(array_sum($ratings) / count($ratings), 2);

        Rating::create([
            'project_id' => $project->id,
            'freelancer_id' => $validated['freelancer_id'],
            'client_id' => Auth::id(),
            'communication_rating' => $validated['communication_rating'],
            'quality_rating' => $validated['quality_rating'],
            'expertise_rating' => $validated['expertise_rating'],
            'delivery_rating' => $validated['delivery_rating'],
            'cooperation_rating' => $validated['cooperation_rating'],
            'rehire_rating' => $validated['rehire_rating'],
            'overall_rating' => $overallRating,
            'review' => $validated['review'],
        ]);

        return redirect()->route('projects.show', $project)->with('success', '✅ تم إرسال التقييم بنجاح');
    }

    public function show(User $user)
    {
        $ratings = $user->ratings()->with(['project', 'client'])->latest()->paginate(10);
        $ratingStats = $user->rating_stats;
        $averageRating = $user->average_rating;
        $ratingsCount = $user->ratings_count;

        return view('ratings.show', compact('user', 'ratings', 'ratingStats', 'averageRating', 'ratingsCount'));
    }
}
