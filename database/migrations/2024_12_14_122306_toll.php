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
        Schema::create('tolls', function (Blueprint $table) {
            $table->id(); // شناسه عوارض
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade'); // ارجاع به خودروی مربوطه
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->onDelete('cascade'); // ارجاع به قرارداد (اختیاری)
            $table->decimal('amount', 10, 2); // مبلغ عوارض
            $table->string('location')->nullable(); // محل عوارضی (اختیاری)
            $table->timestamp('toll_date'); // تاریخ و زمان عبور از عوارضی
            $table->boolean('is_paid')->default(false); // وضعیت پرداخت
            $table->timestamps(); // تاریخ‌های ایجاد و ویرایش
        
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tolls');
    }
};
