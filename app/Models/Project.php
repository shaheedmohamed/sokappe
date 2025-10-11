<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'budget_min',
        'budget_max',
        'duration',
        'category',
        'skills',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_project');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skill');
    }
}
