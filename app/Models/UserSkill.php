<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_name',
        'proficiency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProficiencyTextAttribute()
    {
        $levels = [
            'beginner' => 'مبتدئ',
            'intermediate' => 'متوسط',
            'advanced' => 'متقدم',
            'expert' => 'خبير'
        ];

        return $levels[$this->proficiency] ?? 'متوسط';
    }

    public function getProficiencyColorAttribute()
    {
        $colors = [
            'beginner' => '#ef4444',
            'intermediate' => '#f59e0b',
            'advanced' => '#10b981',
            'expert' => '#8b5cf6'
        ];

        return $colors[$this->proficiency] ?? '#f59e0b';
    }
}
