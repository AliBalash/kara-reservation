<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id(); // شناسه خودرو
            $table->unsignedBigInteger('car_model_id'); // ارجاع به مدل خودرو
            $table->string('plate_number')->unique(); // شماره پلاک خودرو
            $table->enum('status', ['available', 'reserved', 'under_maintenance'])->default('available'); // وضعیت خودرو
            $table->boolean('availability')->default(true); // در دسترس بودن خودرو
            $table->integer('mileage')->default(0); // میزان پیمایش خودرو
            $table->decimal('price_per_day', 10, 2); // قیمت اجاره روزانه خودرو
            $table->date('service_due_date')->nullable(); // تاریخ موعد سرویس
            $table->text('damage_report')->nullable(); // گزارش خسارت
            $table->year('manufacturing_year'); // سال ساخت خودرو
            $table->string('color')->nullable(); // رنگ خودرو
            $table->string('chassis_number')->unique(); // شماره شاسی
            $table->boolean('gps')->default(false); // وضعیت GPS
            $table->text('notes')->nullable(); // یادداشت‌ها
            $table->timestamps(); // زمان‌های ایجاد و ویرایش

            // Foreign key relationship with car_models
            $table->foreign('car_model_id')->references('id')->on('car_models')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
