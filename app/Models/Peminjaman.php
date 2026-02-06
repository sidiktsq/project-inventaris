<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peminjaman extends Model
{
    protected $table = 'peminjaman'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'kode_peminjaman',
        'nama_peminjam',
        'jenis_peminjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'user_id',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    /**
     * Relasi ke DetailPeminjaman
     */
    public function details(): HasMany
    {
        // Pastikan model DetailPeminjaman sudah ada
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }

    /**
     * Relasi ke User (Staff yang menginput)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}