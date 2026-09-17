<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->enum('type', [
                'in',
                'out',
                'sale',
                'adjustment',
            ]);

            $table->integer('quantity');

            $table->unsignedInteger('stock_before');

            $table->unsignedInteger('stock_after');

            /*
             * Contoh:
             * TRX-20260917-0001
             * STOCK-IN
             * STOCK-OUT
             * ADJUSTMENT
             */
            $table->string('reference')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('product_id');

            $table->index('user_id');

            $table->index('type');

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};