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
        Schema::create('payments', function (Blueprint $table) {
            // Menggunakan id standar sesuai dengan model Payment dan file index Livewire kamu
            $table->id(); 

            // Foreign key ke tabel transactions (Disesuaikan dengan primary key 'transaction_id' milikmu)
            $table->foreignId('transaction_id')
                  ->constrained('transactions', 'transaction_id')
                  ->onDelete('cascade');

            $table->string('payment_method');
            $table->decimal('amount_paid', 12, 2);
            $table->string('payment_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};