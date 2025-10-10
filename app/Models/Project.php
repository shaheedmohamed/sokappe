<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'budget_min',
        'budget_max',
        'duration_days',
        'status',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}
