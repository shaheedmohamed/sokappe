<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailedRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'client_id',
        'freelancer_id',
        'bid_id',
        'professionalism_rating',
        'communication_rating',
        'quality_rating',
        'experience_rating',
        'delivery_rating',
        'cooperation_rating',
        'overall_rating',
        'comment',
    ];

    protected $casts = [
        'overall_rating' => 'decimal:1',
    ];

    // العلاقات
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    // حساب التقييم العام
    public function calculateOverallRating()
    {
        $ratings = [
            $this->professionalism_rating,
            $this->communication_rating,
            $this->quality_rating,
            $this->experience_rating,
            $this->delivery_rating,
            $this->cooperation_rating,
        ];

        return round(array_sum($ratings) / count($ratings), 1);
    }

    // أسماء التقييمات
    public static function getRatingLabels()
    {
        return [
            'professionalism_rating' => 'الاحترافية بالتعامل',
            'communication_rating' => 'التواصل والمتابعة',
            'quality_rating' => 'جودة العمل المسلم',
            'experience_rating' => 'الخبرة بمجال المشروع',
            'delivery_rating' => 'التسليم في الموعد',
            'cooperation_rating' => 'التعامل معه مرة أخرى',
        ];
    }
}
