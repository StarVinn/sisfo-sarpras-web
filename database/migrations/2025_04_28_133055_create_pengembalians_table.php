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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id'); // Foreign key ke tabel peminjaman
            $table->foreignId('denda_id')->nullable()->constrained('dendas')->onDelete('set null');
            $table->string('image_bukti')->nullable(); // Menyimpan path gambar bukti pengembalian
            $table->string('kondisi_barang');
            $table->date('tanggal_dikembalikan');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('peminjaman_id')->references('id')->on('peminjamen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
