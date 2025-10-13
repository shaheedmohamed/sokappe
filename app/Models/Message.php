<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message',
        'attachments',
        'read_at',
        'is_system_message',
    ];

    protected $casts = [
        'attachments' => 'array',
        'read_at' => 'datetime',
        'is_system_message' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Alias for sender (for compatibility)
    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Check if message is read
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    // Mark message as read
    public function markAsRead()
    {
        if (!$this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    // Get formatted time
    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('H:i');
    }

    // Get formatted date
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    // Check if message was sent today
    public function isSentToday()
    {
        return $this->created_at->isToday();
    }
}
