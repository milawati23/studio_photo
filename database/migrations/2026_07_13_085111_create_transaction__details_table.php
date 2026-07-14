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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id('transactiondetail_id');

            // Foreign key ke tabel transactions
            $table->foreignId('transaction_id')
                  ->constrained('transactions', 'transaction_id')
                  ->onDelete('cascade');

            // Foreign key ke tabel services
            $table->unsignedBigInteger('service_id');

            $table->foreign('service_id')
                  ->references('service_id')
                  ->on('services')
                  ->onDelete('restrict');

            $table->integer('quantity');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};