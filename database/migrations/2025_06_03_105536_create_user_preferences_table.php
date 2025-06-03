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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('health_condition')->nullable();
            $table->json('preferred_categories')->nullable();
            $table->decimal('min_price', 10, 2)->nullable();
            $table->decimal('max_price', 10, 2)->nullable();
            $table->json('allergic_ingredients')->nullable();
            $table->decimal('weight_kandungan', 3, 2)->default(0.25);
            $table->decimal('weight_khasiat', 3, 2)->default(0.25);
            $table->decimal('weight_harga', 3, 2)->default(0.25);
            $table->decimal('weight_expired', 3, 2)->default(0.25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
