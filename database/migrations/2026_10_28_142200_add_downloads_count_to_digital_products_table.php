<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->unsignedInteger('downloads_count')->default(0)->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->dropColumn('downloads_count');
        });
    }
};
