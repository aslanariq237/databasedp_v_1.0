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
        Schema::create('tandater', function (Blueprint $table) {
            $table->id();            
            $table->string('id_tandater')->nullable();
            $table->string('id_teknisi')->nullable();
            $table->string('id_keluhan')->nullable();
            $table->string('id_customer') ->nullable(); 
            $table->string('customer')->nullable();                                                                   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tandater');
    }
};
