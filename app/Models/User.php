<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'avatar',
        'password',
        'status',
        'national_code',
        'address',
    ];

    /**
     * ویژگی‌های مخفی برای آرایه‌ها.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تبدیل‌های مربوط به نوع داده‌ها.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    /**
     * متد Full Name برای ترکیب نام و نام خانوادگی.
     *
     * @return string
     */
    public function fullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * متد تعیین وضعیت فعال بودن کاربر.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * متد برای هش کردن رمز عبور به صورت خودکار.
     *
     * @param string $password
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * رابطه با مدل Contract (قراردادها).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'user_id');
    }

    /**
     * ارسال نوتیفیکیشن خوش‌آمد به کاربر.
     *
     * @return void
     */
    public function sendWelcomeNotification(): void
    {
        // مثلاً نوتیفیکیشن خوش‌آمد گویی را ارسال می‌کند
        $this->notify(new \App\Notifications\WelcomeNotification($this));
    }
}
