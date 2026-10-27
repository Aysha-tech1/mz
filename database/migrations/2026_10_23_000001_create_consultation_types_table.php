<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_types', function (Blueprint $row) {
            $row->id();
            $row->string('title');
            $row->integer('duration'); // in minutes
            $row->decimal('price', 8, 3); // OMR
            $row->boolean('is_active')->default(true);
            $row->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_types');
    }
};
