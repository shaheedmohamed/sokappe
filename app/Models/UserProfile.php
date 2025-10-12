<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avatar',
        'title',
        'bio',
        'specialization',
        'experience',
        'location',
        'phone',
        'website',
        'linkedin',
        'github',
        'portfolio_video',
        'hourly_rate',
        'available_for_hire',
        'languages',
    ];

    protected $casts = [
        'languages' => 'array',
        'available_for_hire' => 'boolean',
        'hourly_rate' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && file_exists(public_path('storage/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&background=6366f1&color=ffffff&size=200';
    }
}
