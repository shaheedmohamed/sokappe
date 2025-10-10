<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'freelancer_id', // للتوافق مع النسخة القديمة
        'amount',
        'price', // للتوافق مع النسخة القديمة
        'delivery_time',
        'days', // للتوافق مع النسخة القديمة
        'message',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        // استخدم user_id إذا كان موجوداً، وإلا استخدم freelancer_id
        if (!empty($this->user_id)) {
            return $this->belongsTo(User::class, 'user_id');
        } else {
            return $this->belongsTo(User::class, 'freelancer_id');
        }
    }

    // علاقة إضافية للتوافق مع النسخة القديمة
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    // Accessors للتوافق مع الحقول القديمة والجديدة
    public function getAmountAttribute($value)
    {
        return $value ?? $this->attributes['price'] ?? 0;
    }

    public function getDeliveryTimeAttribute($value)
    {
        return $value ?? $this->attributes['days'] ?? 0;
    }

    public function getUserIdAttribute($value)
    {
        return $value ?? $this->attributes['freelancer_id'] ?? null;
    }
}
