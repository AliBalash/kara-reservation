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
        Schema::create('images', function (Blueprint $table) {
            $table->id(); // شناسه یکتا
            $table->string('file_path'); // مسیر ذخیره‌سازی فایل
            $table->string('file_name'); // نام فایل
            $table->unsignedBigInteger('imageable_id'); // شناسه رابطه چندشکلی
            $table->string('imageable_type'); // نوع مدل مرتبط
            $table->timestamps(); // زمان‌های ایجاد و ویرایش
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
