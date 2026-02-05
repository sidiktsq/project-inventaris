<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
{
    Schema::create('detail_peminjamans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('peminjaman_id')->constrained()->onDelete('cascade');
        $table->foreignId('barang_id')->constrained()->onDelete('cascade');
        $table->integer('jumlah');
        $table->enum('kondisi_sebelum', ['baik', 'rusak_ringan', 'rusak_berat']);
        $table->enum('kondisi_sesudah', ['baik', 'rusak_ringan', 'rusak_berat'])->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamans');
    }
};