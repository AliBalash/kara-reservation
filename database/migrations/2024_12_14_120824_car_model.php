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
        Schema::create('car_models', function (Blueprint $table) {
            $table->id(); // شناسه منحصربه‌فرد
            $table->string('brand'); // برند
            $table->string('model'); // مدل
            $table->string('brand_icon')->nullable(); //  ایکون برند 
            $table->float('engine_capacity')->nullable(); // حجم موتور
            $table->enum('fuel_type', ['petrol', 'diesel', 'hybrid', 'electric'])->nullable(); // نوع سوخت
            $table->enum('gearbox_type', ['manual', 'automatic'])->nullable(); // نوع گیربکس
            $table->integer('seating_capacity')->default(4); // ظرفیت سرنشین
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');

    }
};
