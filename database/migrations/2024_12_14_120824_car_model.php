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
            $table->boolean('is_featured')->default(false)->after('brand');

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
