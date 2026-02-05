<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman'; // pastikan ini sesuai dengan nama tabel
    public $timestamps = false;
    
    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'jumlah',
        'kondisi_sebelum'
    ];
    
    // ... relasi

    
    // Relasi dengan model Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
    
    // Relasi dengan model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}