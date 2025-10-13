<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\DetailedRating;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'avatar',
        'role',
        'is_active',
        'is_banned',
        'banned_reason',
        'banned_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // العلاقات
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user1_id')
                    ->orWhere('user2_id', $this->id);
    }

    public function activityLogs()
    {
        return $this->hasMany(UserActivityLog::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }

    public function freelancerProfile()
    {
        return $this->hasOne(FreelancerProfile::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function skills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'freelancer_id');
    }

    public function givenRatings()
    {
        return $this->hasMany(Rating::class, 'client_id');
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->profile && $this->profile->avatar) {
            return $this->profile->avatar_url;
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=ffffff&size=200';
    }

    public function getAverageRatingAttribute()
    {
        // Use detailed ratings if available, otherwise fall back to old ratings
        $detailedAvg = $this->detailedRatings()->avg('overall_rating');
        if ($detailedAvg) {
            return round($detailedAvg, 1);
        }
        
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function detailedRatings()
    {
        return $this->hasMany(DetailedRating::class, 'freelancer_id');
    }

    /**
     * العلاقة مع المحفظة
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * العلاقة مع المعاملات
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * التحقق من صلاحيات الإدارة
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getRatingsCountAttribute()
    {
        // Count detailed ratings first, then old ratings
        $detailedCount = $this->detailedRatings()->count();
        if ($detailedCount > 0) {
            return $detailedCount;
        }
        
        return $this->ratings()->count();
    }

    public function getRatingStatsAttribute()
    {
        $ratings = $this->ratings;
        
        if ($ratings->isEmpty()) {
            return [
                'communication' => 0,
                'quality' => 0,
                'expertise' => 0,
                'delivery' => 0,
                'cooperation' => 0,
                'rehire' => 0,
            ];
        }

        return [
            'communication' => round($ratings->avg('communication_rating'), 2),
            'quality' => round($ratings->avg('quality_rating'), 2),
            'expertise' => round($ratings->avg('expertise_rating'), 2),
            'delivery' => round($ratings->avg('delivery_rating'), 2),
            'cooperation' => round($ratings->avg('cooperation_rating'), 2),
            'rehire' => round($ratings->avg('rehire_rating'), 2),
        ];
    }

    public static function generateUsername($name)
    {
        // Remove spaces and special characters, convert to lowercase
        $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        
        // If empty, use 'user'
        if (empty($baseUsername)) {
            $baseUsername = 'user';
        }
        
        // Check if username exists
        $username = $baseUsername;
        $counter = 1;
        
        while (self::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        return $username;
    }

    public function getRouteKeyName()
    {
        return 'username';
    }
}
