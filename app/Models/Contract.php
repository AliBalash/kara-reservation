<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    /**
     * ویژگی‌های قابل پر کردن (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'customer_id',
        'car_id',
        'agent_sale',
        'pickup_date',
        'pickup_location',
        'return_location',
        'return_date',
        'total_price',
        'current_status',
        'notes',
    ];

    /**
     * تبدیل‌های مربوط به نوع داده‌ها.
     *
     * @var array
     */
    protected $casts = [
        'pickup_date' => 'datetime',
        'return_date' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    /**
     * متد برای دریافت وضعیت قرارداد.
     *
     * @return string
     */
    public function statusLabel(): string
    {
        return ucfirst($this->current_status); // نمایش وضعیت قرارداد با حرف اول بزرگ
    }

    /**
     * متد برای بررسی وضعیت قرارداد (فعال یا تکمیل شده).
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->current_status === 'assigned' || $this->current_status === 'under_review' || $this->current_status === 'delivery_in_progress';
    }

    /**
     * متد برای بررسی اینکه قرارداد کامل شده است یا خیر.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->current_status === 'complete';
    }

    /**
     * رابطه با مدل User (کارشناس).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * رابطه با مدل Customer (مشتری).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * رابطه با مدل Car (خودرو).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }


    // Relationship with CustomerDocument model
    public function customerDocument()
    {
        return $this->hasOne(CustomerDocument::class);
    }

    // Relationship with Payment model
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // ارتباط با تاریخچه وضعیت‌ها
    public function statuses()
    {
        return $this->hasMany(ContractStatus::class);
    }

    // تغییر وضعیت درخواست
    public function changeStatus($newStatus, $userId, $notes = null)
    {
        $this->statuses()->create([
            'status' => $newStatus,
            'user_id' => $userId,
            'notes' => $notes,
        ]);

        $this->update(['current_status' => $newStatus]);

        // اگر وضعیت به pending تغییر کرد
        if ($newStatus === 'pending') {
            $this->initializeContract();
        }

        // اگر وضعیت به complete تغییر کرد
        if ($newStatus === 'complete') {
            $this->finalizeContract();
        }
    }

    // متد جدید برای ثبت تاریخ شروع قرارداد
    public function initializeContract()
    {
        if (!$this->pickup_date) {
            $this->update([
                'pickup_date' => now(),  // ثبت تاریخ شروع قرارداد
            ]);
        }
    }

    // متد برای نهایی‌سازی درخواست
    public function finalizeContract()
    {
        $this->update([
            'return_date' => now(),  // ثبت تاریخ پایان قرارداد
        ]);
    }

    public function pickupDocument()
    {
        return $this->hasOne(PickupDocument::class);
    }
    // همه‌ی آیتم‌های قیمت
    public function charges()
    {
        return $this->hasMany(ContractCharges::class);
    }

    // محاسبه مجموع مبلغ از روی آیتم‌ها
    public function calculateTotalPrice()
    {
        return $this->charges()->sum('amount');
    }

    // بروزرسانی ستون total_price
    public function updateTotalPrice()
    {
        $total = $this->calculateTotalPrice();
        $this->update(['total_price' => $total]);
        return $total;
    }

    // گرفتن آیتم‌ها بر اساس نوع (Base, Addon, Location, Deposit)
    public function getChargesByType(string $type)
    {
        return $this->charges()->where('type', $type)->get();
    }
}
