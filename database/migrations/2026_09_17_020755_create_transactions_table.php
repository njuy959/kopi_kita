<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_number')
                ->unique();

            $table->foreignId('cashier_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('subtotal', 12, 2)
                ->default(0);

            $table->decimal('discount', 12, 2)
                ->default(0);

            $table->decimal('total', 12, 2)
                ->default(0);

            $table->enum('payment_method', [
                'cash',
                'qris',
                'debit',
                'e_wallet',
            ]);

            $table->decimal('paid_amount', 12, 2)
                ->default(0);

            $table->decimal('change_amount', 12, 2)
                ->default(0);

            $table->enum('status', [
                'pending',
                'completed',
                'cancelled',
            ])->default('completed');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('cashier_id');

            $table->index('payment_method');

            $table->index('status');

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};