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
        Schema::create('camp_benefits', function (Blueprint $table) {
            $table->id();
            // 1st method
            // $table->bigInteger('camp_id')->unsigned(); note: verify id reference if defined as unsigned()

            $table->foreignId('camp_id')->constrained();
            $table->string('name');
            $table->timestamps();

            // 1st method
            // $table->foreign('camp_id')->references('id')->on('camp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camp_benefits');
    }
};
