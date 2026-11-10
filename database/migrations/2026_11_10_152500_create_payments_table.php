<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('payments')) {
            $this->repairIndexes();

            return;
        }

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_product_id')->constrained()->cascadeOnDelete();
            $table->string('email', 191);
            $table->decimal('amount', 10, 3);
            $table->string('currency', 3)->default('OMR');
            $table->string('status', 20)->default('pending');
            $table->string('reference', 40)->unique();
            $table->string('gateway', 20)->default('ompay');
            $table->string('gateway_transaction_id', 191)->nullable()->unique();
            $table->json('gateway_payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['digital_product_id', 'status']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }

    private function repairIndexes(): void
    {
        $indexes = collect(Schema::getIndexes('payments'))->pluck('name');

        Schema::table('payments', function (Blueprint $table) use ($indexes) {
            if ($indexes->contains('payments_email_status_index')) {
                $table->dropIndex('payments_email_status_index');
            }
        });

        DB::statement('ALTER TABLE payments MODIFY email VARCHAR(191) NOT NULL');
        DB::statement('ALTER TABLE payments MODIFY gateway_transaction_id VARCHAR(191) NULL');
    }
};
