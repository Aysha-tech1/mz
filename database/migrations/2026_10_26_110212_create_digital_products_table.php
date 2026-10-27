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
        Schema::create('digital_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('label'); // e.g., "دليل عملي", "نموذج جاهز"
            $table->integer('step_number')->default(1); // Step number (1-8)
            $table->decimal('price', 8, 3)->default(0);
            $table->boolean('is_free')->default(false);
            $table->string('file_path')->nullable(); // Path to the downloadable file
            $table->boolean('is_active')->default(true);
            $table->string('old_price', 8, 3)->nullable(); // For special offers
            $table->boolean('is_coming_soon')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_products');
    }
};
