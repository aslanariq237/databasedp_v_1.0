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
        Schema::create('detailBarang', function(Blueprint $table){
            $table->id(); 
            $table->string('id_tandater');
            $table->string('id_customer');
            $table->string('id_teknisi')->nullable();           
            $table->string('nama_barang')->nullable();
            $table->string('status')->nullable();
            $table->integer('cost')->nullable();            
            $table->string('SN')->nullable();
            $table->boolean('garansi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
