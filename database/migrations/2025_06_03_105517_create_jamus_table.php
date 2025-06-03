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
        Schema::create('jamus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jamu');
            $table->string('kategori');
            $table->text('kandungan');
            $table->decimal('harga', 10, 2);
            $table->text('khasiat');
            $table->text('efek_samping')->nullable();
            $table->date('expired_date');
            $table->integer('nilai_kandungan');
            $table->integer('nilai_khasiat');
            $table->text('deskripsi')->nullable();
            $table->string('cara_penggunaan')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamus');
    }
};
