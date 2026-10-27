<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $row) {
            $row->id();
            $row->foreignId('consultation_type_id')->constrained();
            $row->string('name');
            $row->string('email');
            $row->string('phone');
            $row->text('topic');
            $row->date('date');
            $row->time('time');
            $row->string('status')->default('pending'); // pending, confirmed, cancelled
            $row->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
