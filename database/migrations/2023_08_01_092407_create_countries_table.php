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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('short_code')->nullable();
            $table->string('name');
            $table->string('timezone')->nullable();
            $table->string('phone_code')->nullable();
            $table->foreignId('continent_id')
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->softDeletesTz();

            #index
            $table->fullText('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
