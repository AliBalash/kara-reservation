<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('code')->unique();
            $table->integer('discount_percentage');
            $table->timestamp('registery_at')->nullable();
            $table->boolean('contacted')->default(false); // True yani tamas gerefte shode, false yani hanuz tamas gerefte nashode

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
