<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->boolean('show_real_sales')->default(true)->after('downloads_count');
            $table->unsignedInteger('displayed_sales_count')->nullable()->after('show_real_sales');
        });
    }

    public function down(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->dropColumn(['show_real_sales', 'displayed_sales_count']);
        });
    }
};
