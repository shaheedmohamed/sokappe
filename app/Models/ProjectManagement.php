<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectManagement extends Model
{
    use HasFactory;

    protected $table = 'project_management';

    protected $fillable = [
        'project_id',
        'client_id',
        'freelancer_id',
        'accepted_bid_id',
        'status',
        'started_at',
        'delivered_at',
        'completed_at',
        'client_notes',
        'freelancer_notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
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

    public function acceptedBid()
    {
        return $this->belongsTo(Bid::class, 'accepted_bid_id');
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class, 'project_id', 'project_id');
    }

    // دوال مساعدة
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function canBeDelivered()
    {
        return $this->status === 'in_progress';
    }

    public function canBeCompleted()
    {
        return $this->status === 'delivered';
    }

    // تحديث الحالة
    public function markAsDelivered()
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
