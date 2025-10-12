<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'device_type',
        'browser',
        'additional_data',
    ];

    protected $casts = [
        'additional_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActionTextAttribute()
    {
        $actions = [
            'login' => '🔑 تسجيل دخول',
            'logout' => '🚪 تسجيل خروج',
            'register' => '👋 تسجيل جديد',
            'password_reset' => '🔐 إعادة تعيين كلمة المرور',
            'profile_update' => '👤 تحديث الملف الشخصي',
            'project_create' => '📋 إنشاء مشروع',
            'service_create' => '⚡ إنشاء خدمة',
            'bid_create' => '💼 تقديم عرض',
        ];

        return $actions[$this->action] ?? $this->action;
    }

    public function getDeviceIconAttribute()
    {
        $icons = [
            'desktop' => '🖥️',
            'mobile' => '📱',
            'tablet' => '📱',
            'bot' => '🤖',
        ];

        return $icons[$this->device_type] ?? '💻';
    }
}
