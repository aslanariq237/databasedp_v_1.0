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
        Schema::create('detkel', function (Blueprint $table) {
            $table->id();
            $table->string('id_barang');
            $table->string('id_keluhan')->nullable();
            $table->string('id_tandater');
            $table->string('nama_keluhan');            
            $table->string('biaya_keluhan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detkel');
    }
};
