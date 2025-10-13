<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'pending_balance',
        'total_earned',
        'total_withdrawn',
        'currency',
        'is_active',
        'last_transaction_at',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'total_withdrawn' => 'decimal:2',
        'is_active' => 'boolean',
        'last_transaction_at' => 'datetime',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع المعاملات
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * المعاملات المكتملة فقط
     */
    public function completedTransactions()
    {
        return $this->hasMany(Transaction::class)->where('status', 'completed');
    }

    /**
     * المعاملات المعلقة
     */
    public function pendingTransactions()
    {
        return $this->hasMany(Transaction::class)->where('status', 'pending');
    }

    /**
     * إضافة رصيد للمحفظة
     */
    public function addBalance($amount, $description = null)
    {
        $this->increment('balance', $amount);
        $this->increment('total_earned', $amount);
        $this->update(['last_transaction_at' => now()]);

        return $this->createTransaction([
            'type' => 'deposit',
            'amount' => $amount,
            'net_amount' => $amount,
            'status' => 'completed',
            'description' => $description ?? 'إضافة رصيد',
            'completed_at' => now(),
        ]);
    }

    /**
     * خصم رصيد من المحفظة
     */
    public function deductBalance($amount, $description = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('الرصيد غير كافي');
        }

        $this->decrement('balance', $amount);
        $this->increment('total_withdrawn', $amount);
        $this->update(['last_transaction_at' => now()]);

        return $this->createTransaction([
            'type' => 'withdrawal',
            'amount' => $amount,
            'net_amount' => $amount,
            'status' => 'completed',
            'description' => $description ?? 'سحب رصيد',
            'completed_at' => now(),
        ]);
    }

    /**
     * تجميد رصيد (نقل إلى المعلق)
     */
    public function freezeBalance($amount, $description = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('الرصيد غير كافي للتجميد');
        }

        $this->decrement('balance', $amount);
        $this->increment('pending_balance', $amount);
        $this->update(['last_transaction_at' => now()]);

        return $this->createTransaction([
            'type' => 'payment',
            'amount' => $amount,
            'net_amount' => $amount,
            'status' => 'pending',
            'description' => $description ?? 'تجميد رصيد',
        ]);
    }

    /**
     * إلغاء تجميد الرصيد
     */
    public function unfreezeBalance($amount, $description = null)
    {
        if ($this->pending_balance < $amount) {
            throw new \Exception('الرصيد المعلق غير كافي');
        }

        $this->decrement('pending_balance', $amount);
        $this->increment('balance', $amount);
        $this->update(['last_transaction_at' => now()]);

        return $this->createTransaction([
            'type' => 'refund',
            'amount' => $amount,
            'net_amount' => $amount,
            'status' => 'completed',
            'description' => $description ?? 'إلغاء تجميد رصيد',
            'completed_at' => now(),
        ]);
    }

    /**
     * إنشاء معاملة جديدة
     */
    protected function createTransaction($data)
    {
        return $this->transactions()->create(array_merge($data, [
            'user_id' => $this->user_id,
            'transaction_id' => 'TXN_' . time() . '_' . rand(1000, 9999),
            'currency' => $this->currency,
            'fee' => $data['fee'] ?? 0,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));
    }

    /**
     * الحصول على إجمالي الرصيد (متاح + معلق)
     */
    public function getTotalBalanceAttribute()
    {
        return $this->balance + $this->pending_balance;
    }

    /**
     * التحقق من كفاية الرصيد
     */
    public function hasBalance($amount)
    {
        return $this->balance >= $amount;
    }

    /**
     * تنسيق الرصيد للعرض
     */
    public function getFormattedBalanceAttribute()
    {
        return number_format($this->balance, 2) . ' ' . $this->currency;
    }

    /**
     * إنشاء محفظة تلقائياً للمستخدم
     */
    public static function createForUser($userId, $currency = 'USD')
    {
        return static::create([
            'user_id' => $userId,
            'currency' => $currency,
        ]);
    }
}
