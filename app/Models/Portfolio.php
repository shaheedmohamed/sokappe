<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'technologies',
        'project_url',
        'github_url',
        'images',
        'completion_date',
        'is_featured',
        'views_count',
    ];

    protected $casts = [
        'technologies' => 'array',
        'images' => 'array',
        'completion_date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMainImageAttribute()
    {
        if ($this->images && count($this->images) > 0) {
            return asset('storage/' . $this->images[0]);
        }
        
        return 'https://via.placeholder.com/400x300/6366f1/ffffff?text=No+Image';
    }

    public function getImageUrlsAttribute()
    {
        if (!$this->images) {
            return [];
        }

        return array_map(function($image) {
            return asset('storage/' . $image);
        }, $this->images);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getCategoryNameAttribute()
    {
        $categories = [
            'web-development' => 'تطوير المواقع',
            'mobile-development' => 'تطوير التطبيقات',
            'ui-ux-design' => 'تصميم UI/UX',
            'graphic-design' => 'التصميم الجرافيكي',
            'digital-marketing' => 'التسويق الرقمي',
            'content-writing' => 'كتابة المحتوى',
            'translation' => 'الترجمة',
            'data-analysis' => 'تحليل البيانات',
        ];

        return $categories[$this->category] ?? $this->category;
    }
}
