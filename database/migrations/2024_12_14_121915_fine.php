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
        Schema::create('fines', function (Blueprint $table) {
            $table->id(); // شناسه جریمه
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade'); // ارجاع به قرارداد مرتبط
            $table->decimal('amount', 10, 2); // مبلغ جریمه
            $table->string('description'); // توضیحات جریمه
            $table->date('fine_date'); // تاریخ وقوع جریمه
            $table->boolean('is_paid')->default(false); // وضعیت پرداخت
            $table->timestamps(); // زمان‌های ایجاد و ویرایش
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');

    }
};