<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'bid_id',
        'client_id',
        'freelancer_id',
        'agreed_price',
        'duration_days',
        'status', // pending, active, completed, cancelled
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function project() { return $this->belongsTo(Project::class); }
    public function bid() { return $this->belongsTo(Bid::class); }
    public function client() { return $this->belongsTo(User::class, 'client_id'); }
    public function freelancer() { return $this->belongsTo(User::class, 'freelancer_id'); }
}
