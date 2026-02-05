@extends('layouts.dashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Transaksi /</span> Edit Peminjaman
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Ubah Data: {{ $peminjaman->kode_peminjaman }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <label class="form-label fw-bold text-primary">Status Peminjaman</label>
                        <select class="form-select form-select-lg" name="status" required>
                            <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>DIPINJAM</option>
                            <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>DIKEMBALIKAN (Selesai)</option>
                            <option value="terlambat" {{ $peminjaman->status == 'terlambat' ? 'selected' : '' }}>TERLAMBAT</option>
                        </select>
                        <div class="form-text text-warning italic">* Mengubah ke 'DIKEMBALIKAN' akan menambah stok barang kembali otomatis.</div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nama Peminjam</label>
                        <input type="text" class="form-control" name="nama_peminjam" value="{{ $peminjaman->nama_peminjam }}" required>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Tanggal Estimasi Kembali</label>
                        <input type="date" class="form-control" name="tanggal_kembali" value="{{ $peminjaman->tanggal_kembali }}" required>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Catatan Kondisi Barang (Saat Kembali)</label>
                        <textarea class="form-control" name="kondisi_sesudah" rows="2" placeholder="Contoh: Kembali dalam keadaan baik">{{ $peminjaman->details->first()->kondisi_sesudah ?? '' }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">Update Data</button>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection