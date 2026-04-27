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
        Schema::create('finishes', function (Blueprint $table) {
            $table->id('id_final');            
            $table->string('id_tandater');                        
            $table->integer('total_biaya');
            $table->string('jasa_service');
            $table->string('ppn');            
            $table->boolean('status_pay');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final');
    }
};
