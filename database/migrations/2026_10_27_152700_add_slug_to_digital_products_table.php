<?php

use App\Models\DigitalProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        DigitalProduct::query()->each(function (DigitalProduct $product): void {
            $product->slug = DigitalProduct::uniqueSlugFromTitle($product->title, $product->id);
            $product->saveQuietly();
        });
    }

    public function down(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
