<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Support\Str;

class Barang extends Model
{
    protected $table = 'barang';
    
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'kondisi',
        'jumlah',
        'satuan',
        'harga',
        'tanggal_beli',
        'deskripsi',
        'foto'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->kode_barang = 'BRG-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        });
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
}