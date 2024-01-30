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
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ticker');
            $table->string('figi')->unique();
            $table->string('isin');
            $table->unsignedMediumInteger('lot');
            $table->unsignedBigInteger('issue_size');
            $table->unsignedBigInteger('issue_size_plan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shares');
    }
};
