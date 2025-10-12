<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'freelancer_id',
        'client_id',
        'communication_rating',
        'quality_rating',
        'expertise_rating',
        'delivery_rating',
        'cooperation_rating',
        'rehire_rating',
        'overall_rating',
        'review',
    ];

    protected $casts = [
        'overall_rating' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function calculateOverallRating()
    {
        $ratings = [
            $this->communication_rating,
            $this->quality_rating,
            $this->expertise_rating,
            $this->delivery_rating,
            $this->cooperation_rating,
            $this->rehire_rating
        ];

        return round(array_sum($ratings) / count($ratings), 2);
    }

    public function getRatingCategoriesAttribute()
    {
        return [
            'communication' => [
                'name' => 'التواصل والتفاهم',
                'rating' => $this->communication_rating
            ],
            'quality' => [
                'name' => 'جودة العمل المسلم',
                'rating' => $this->quality_rating
            ],
            'expertise' => [
                'name' => 'الخبرة بالمجال المطلوب',
                'rating' => $this->expertise_rating
            ],
            'delivery' => [
                'name' => 'التسليم بالموعد',
                'rating' => $this->delivery_rating
            ],
            'cooperation' => [
                'name' => 'التعامل والأخلاق المهنية',
                'rating' => $this->cooperation_rating
            ],
            'rehire' => [
                'name' => 'إعادة التوظيف',
                'rating' => $this->rehire_rating
            ]
        ];
    }
}
