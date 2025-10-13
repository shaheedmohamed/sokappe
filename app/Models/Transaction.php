<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'user_id',
        'transaction_id',
        'type',
        'amount',
        'fee',
        'net_amount',
        'currency',
        'status',
        'payment_method',
        'external_id',
        'gateway_response',
        'description',
        'notes',
        'project_id',
        'bid_id',
        'processed_at',
        'completed_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'gateway_response' => 'array',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // أنواع المعاملات
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_PAYMENT = 'payment';
    const TYPE_REFUND = 'refund';
    const TYPE_COMMISSION = 'commission';
    const TYPE_BONUS = 'bonus';

    // حالات المعاملات
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * العلاقة مع المحفظة
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع المشروع
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * العلاقة مع العرض
     */
    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    /**
     * تحديث حالة المعاملة
     */
    public function updateStatus($status, $notes = null)
    {
        $this->update([
            'status' => $status,
            'notes' => $notes,
            'processed_at' => in_array($status, [self::STATUS_PROCESSING, self::STATUS_COMPLETED]) ? now() : null,
            'completed_at' => $status === self::STATUS_COMPLETED ? now() : null,
        ]);

        return $this;
    }

    /**
     * تأكيد المعاملة
     */
    public function confirm($externalId = null, $gatewayResponse = null)
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'external_id' => $externalId,
            'gateway_response' => $gatewayResponse,
            'completed_at' => now(),
        ]);

        return $this;
    }

    /**
     * فشل المعاملة
     */
    public function fail($reason = null, $gatewayResponse = null)
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'notes' => $reason,
            'gateway_response' => $gatewayResponse,
            'processed_at' => now(),
        ]);

        return $this;
    }

    /**
     * إلغاء المعاملة
     */
    public function cancel($reason = null)
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'notes' => $reason,
            'processed_at' => now(),
        ]);

        return $this;
    }

    /**
     * التحقق من حالة المعاملة
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isProcessing()
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * الحصول على وصف نوع المعاملة
     */
    public function getTypeDescriptionAttribute()
    {
        $types = [
            self::TYPE_DEPOSIT => 'إيداع',
            self::TYPE_WITHDRAWAL => 'سحب',
            self::TYPE_PAYMENT => 'دفع',
            self::TYPE_REFUND => 'استرداد',
            self::TYPE_COMMISSION => 'عمولة',
            self::TYPE_BONUS => 'مكافأة',
        ];

        return $types[$this->type] ?? $this->type;
    }

    /**
     * الحصول على وصف حالة المعاملة
     */
    public function getStatusDescriptionAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'معلقة',
            self::STATUS_PROCESSING => 'قيد المعالجة',
            self::STATUS_COMPLETED => 'مكتملة',
            self::STATUS_FAILED => 'فاشلة',
            self::STATUS_CANCELLED => 'ملغية',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * الحصول على لون حالة المعاملة
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_FAILED => 'danger',
            self::STATUS_CANCELLED => 'secondary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * تنسيق المبلغ للعرض
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2) . ' ' . $this->currency;
    }

    /**
     * تنسيق المبلغ الصافي للعرض
     */
    public function getFormattedNetAmountAttribute()
    {
        return number_format($this->net_amount, 2) . ' ' . $this->currency;
    }

    /**
     * Scopes للاستعلامات
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
