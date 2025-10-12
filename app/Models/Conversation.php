<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'bid_id',
        'client_id',
        'freelancer_id',
        'subject',
        'last_message_at',
        'is_active',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    // Get the other participant in the conversation
    public function getOtherParticipant($userId)
    {
        return $this->client_id == $userId ? $this->freelancer : $this->client;
    }

    // Get unread messages count for a specific user
    public function getUnreadCountForUser($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();
    }

    // Mark all messages as read for a specific user
    public function markAsReadForUser($userId)
    {
        $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    // Update last message timestamp
    public function updateLastMessageTime()
    {
        $this->update(['last_message_at' => now()]);
    }
}
