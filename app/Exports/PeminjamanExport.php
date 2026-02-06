<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Peminjaman::with(['user', 'details.barang'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Peminjaman',
            'Nama Peminjam',
            'Jenis Peminjam',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
            'Petugas',
            'Barang Dipinjam',
        ];
    }

    public function map($peminjaman): array
    {
        $barangList = $peminjaman->details->map(function($detail) {
            return optional($detail->barang)->nama_barang . ' (' . $detail->jumlah . ')';
        })->implode(', ');

        return [
            $peminjaman->id,
            $peminjaman->kode_peminjaman,
            $peminjaman->nama_peminjam,
            $peminjaman->jenis_peminjam,
            $peminjaman->tanggal_pinjam,
            $peminjaman->tanggal_kembali,
            ucfirst($peminjaman->status),
            optional($peminjaman->user)->name,
            $barangList,
        ];
    }
}