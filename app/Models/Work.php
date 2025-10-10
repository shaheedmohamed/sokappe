<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'thumbnail',
        'description',
        'media_paths',
        'preview_url',
        'delivered_at',
        'skills',
        'terms_accepted',
    ];

    protected $casts = [
        'delivered_at' => 'date',
        'terms_accepted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
