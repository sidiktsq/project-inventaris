@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Peminjaman #{{ $peminjaman->kode_peminjaman }}</h5>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class='bx bx-check-circle me-2'></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class='bx bx-error-circle me-2'></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted">Informasi Peminjaman</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="fw-semibold">Kode Peminjaman:</span>
                            <span class="ms-2">{{ $peminjaman->kode_peminjaman }}</span>
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
                            <span class="badge bg-{{ $peminjaman->status == 'dipinjam' ? 'warning' : ($peminjaman->status == 'terlambat' ? 'danger' : 'success') }} text-uppercase">
                                {{ $peminjaman->status }}
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Informasi Peminjam</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="fw-semibold">Nama Peminjam:</span>
                            <span class="ms-2">{{ $peminjaman->nama_peminjam }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">Jenis Peminjam:</span>
                            <span class="ms-2 badge bg-label-info">{{ ucfirst($peminjaman->jenis_peminjam) }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">Petugas Input:</span>
                            <span class="ms-2">{{ $peminjaman->user->name }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive">
                <h6 class="text-muted mb-3">Daftar Barang</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th>Kondisi Sebelum</th>
                            <th>Kondisi Sesudah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->barang->nama_barang }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td>{{ $detail->kondisi_sebelum }}</td>
                            <td>{{ $detail->kondisi_sesudah ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada barang yang dipinjam</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <small class="text-muted">
                    <i class='bx bx-calendar'></i> Dibuat: {{ $peminjaman->created_at->format('d M Y H:i') }}
                </small>
                <small class="text-muted ms-3">
                    <i class='bx bx-calendar-edit'></i> Diperbarui: {{ $peminjaman->updated_at->format('d M Y H:i') }}
                </small>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-primary">
                        <i class="bx bx-edit me-1"></i> Edit
                    </a>
                </div>
                <div>
                    @if($peminjaman->status === 'dipinjam')
                        <form action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan semua barang ini?');">
                            @csrf
                            <button class="btn btn-success me-2">
                                <i class='bx bx-check-double me-1'></i> Kembalikan Barang
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class='bx bx-trash me-1'></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection