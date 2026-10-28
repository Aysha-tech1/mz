<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('file_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_product_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20)->default('download');
            $table->string('filename')->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['digital_product_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_sales');
    }
};
