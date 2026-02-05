@extends('layouts.dashboard')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Peminjaman #{{ $peminjaman->kode_transaksi }}</h5>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted">Informasi Peminjaman</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="fw-semibold">Kode Transaksi:</span>
                            <span class="ms-2">{{ $peminjaman->kode_transaksi }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">Tanggal Pinjam:</span>
                            <span class="ms-2">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">Tanggal Kembali:</span>
                            <span class="ms-2">{{ $peminjaman->tanggal_kembali->format('d M Y') }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">Status:</span>
                            <span class="badge bg-{{ $peminjaman->status == 'dipinjam' ? 'warning' : 'success' }} text-uppercase">
                                {{ $peminjaman->status }}
                            </span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">Keterangan:</span>
                            <span class="ms-2">{{ $peminjaman->keterangan ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Informasi Peminjam</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="fw-semibold">Nama Peminjam:</span>
                            <span class="ms-2">{{ $peminjaman->user->name }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">Email:</span>
                            <span class="ms-2">{{ $peminjaman->user->email }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">No. Telepon:</span>
                            <span class="ms-2">{{ $peminjaman->user->phone ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive">
                <h6 class="text-muted mb-3">Daftar Barang</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $peminjaman->barang->nama_barang }}</td>
                            <td class="text-center">{{ $peminjaman->jumlah }}</td>
                            <td>{{ $peminjaman->kondisi_barang }}</td>
                            <td>{{ $peminjaman->keterangan_barang ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($peminjaman->pengembalian)
            <div class="mt-4">
                <h6 class="text-muted mb-3">Informasi Pengembalian</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Tanggal Dikembalikan</th>
                            <td>{{ $peminjaman->pengembalian->tanggal_pengembalian->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Kondisi Barang</th>
                            <td>
                                <span class="badge bg-{{ $peminjaman->pengembalian->kondisi_barang == 'baik' ? 'success' : 'danger' }}">
                                    {{ ucfirst($peminjaman->pengembalian->kondisi_barang) }}
                                </span>
                            </td>
                        </tr>
                        @if($peminjaman->pengembalian->denda > 0)
                        <tr>
                            <th>Denda</th>
                            <td>Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $peminjaman->pengembalian->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-primary">
                        <i class="bx bx-edit me-1"></i> Edit
                    </a>
                </div>
                <div>
                    @if($peminjaman->status == 'dipinjam' && !$peminjaman->pengembalian)
                    <a href="{{ route('pengembalian.create', ['peminjaman_id' => $peminjaman->id]) }}" 
                       class="btn btn-success">
                        <i class="bx bx-check-circle me-1"></i> Proses Pengembalian
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection