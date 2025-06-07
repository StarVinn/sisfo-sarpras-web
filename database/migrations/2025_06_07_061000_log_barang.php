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
        Schema::create('log_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->enum('aksi', ['TAMBAH', 'UBAH', 'HAPUS']);
            $table->string('nama_barang');
            $table->integer('quantity');
            $table->string('kondisi');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // 👉 Tambahkan kolom user_id
            $table->timestamp('waktu_log')->useCurrent();

            // Optional foreign keys:
            // $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            // $table->foreign('barang_id')->references('id')->on('barangs')->nullOnDelete();
            // $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_barang');
    }
};
