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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users
            $table->unsignedBigInteger('barang_id')->nullable(); // Foreign key ke tabel barangs
            $table->string('kelas_peminjam');
            $table->text('alasan_peminjam');
            $table->date('tanggal_peminjaman');
            $table->enum('status', ['waiting peminjaman', 'Dipinjam', 'waiting pengembalian', 'Dikembalikan', 'peminjaman ditolak', 'pengembalian ditolak'])->default('waiting peminjaman');
            $table->text('alasan_penolakan')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
