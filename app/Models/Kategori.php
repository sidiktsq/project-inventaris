<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table    = 'kategori'; // Nama tabel sesuai diagram
    protected $fillable = ['nama', 'deskripsi'];

    // Relasi ke tabel barang (One to Many)
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}