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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id(); // شناسه بیمه
            $table->unsignedBigInteger('car_id'); // ارجاع به جدول خودرو
            $table->date('expiry_date')->nullable(); // تاریخ انقضای بیمه
            $table->integer('valid_days')->nullable(); // تعداد روزهای اعتبار بیمه
            $table->enum('status', ['done', 'pending', 'failed'])->default('pending'); // وضعیت بیمه
            $table->string('insurance_company')->nullable(); // شرکت بیمه
            $table->timestamps(); // زمان‌های ایجاد و ویرایش
    
            // Foreign key relationship with cars
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
