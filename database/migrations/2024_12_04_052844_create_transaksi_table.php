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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id');
            $table->string('id_transaksi');
            $table->string('no_invoice');
            $table->string('id_customer');
            $table->string('id_final');
            $table->string('id_tandater');
            $table->integer('total_biaya');
            $table->integer('ppn');
            $table->integer('jasa_service');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
