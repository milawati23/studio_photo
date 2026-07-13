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
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id'); // bigint, Primary Key
            $table->string("service_name"); // Nama layanan (string)
            $table->foreignId('category_id')->constrained('categories', 'category_id')->onDelete('cascade');
            $table->decimal("price", 10, 2); // Harga (decimal) dengan 2 angka di belakang koma
            $table->text("description")->nullable(); // Deskripsi layanan (boleh kosong)
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
