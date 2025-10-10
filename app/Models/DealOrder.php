<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'buyer_id',
        'seller_id',
        'amount',
        'status', // 'pending', 'paid', 'completed', 'disputed', 'cancelled'
        'escrow_status', // 'held', 'released', 'refunded'
        'notes',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
