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
        Schema::create('processing_lines', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignId('section_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->mediumText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing_lines');
    }
};
