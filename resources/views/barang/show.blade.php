@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>

        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

        <div class="row">
            <!-- Main Info -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class='bx bx-package me-2'></i>Detail Barang</h5>
                        <div>
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm btn-edit" data-id="{{ $barang->id }}">
                                <i class='bx bx-edit'></i> Edit
                            </a>
                            <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class='bx bx-arrow-back'></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Image & Basic Info -->
                        <div class="row mb-4">
                            <div class="col-md-5">
                                @if($barang->foto)
                                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}"
                                        class="img-fluid rounded border" style="width:100%; max-height:400px; object-fit:cover;" />
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center border"
                                        style="width:100%; height:300px;">
                                        <div class="text-muted text-center">
                                            <i class="bx bx-image" style="font-size:64px;"></i>
                                            <p class="mt-2">Tidak ada foto</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <h4 class="mb-3">{{ $barang->nama_barang }}</h4>
                                
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 40%"><i class='bx bx-barcode me-2'></i>Kode Barang</td>
                                        <td><span class="badge bg-label-dark">{{ $barang->kode_barang }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class='bx bx-category-alt me-2'></i>Kategori</td>
                                        <td>
                                            @if($barang->kategori)
                                                <a href="{{ route('kategori.show', $barang->kategori->id) }}" class="badge bg-label-primary">
                                                    {{ $barang->kategori->nama }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class='bx bx-map me-2'></i>Lokasi</td>
                                        <td>
                                            @if($barang->lokasi)
                                                <a href="{{ route('lokasi.show', $barang->lokasi->id) }}" class="badge bg-label-info">
                                                    {{ $barang->lokasi->nama }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class='bx bx-check-shield me-2'></i>Kondisi</td>
                                        <td>
                                            @if($barang->kondisi == 'baik')
                                                <span class="badge bg-success"><i class='bx bx-check-circle'></i> Baik</span>
                                            @elseif($barang->kondisi == 'rusak_ringan')
                                                <span class="badge bg-warning"><i class='bx bx-error'></i> Rusak Ringan</span>
                                            @elseif($barang->kondisi == 'rusak_berat')
                                                <span class="badge bg-danger"><i class='bx bx-x-circle'></i> Rusak Berat</span>
                                            @elseif($barang->kondisi == 'hilang')
                                                <span class="badge bg-secondary"><i class='bx bx-help-circle'></i> Hilang</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class='bx bx-package me-2'></i>Stok</td>
                                        <td>
                                            <strong>{{ number_format($barang->jumlah) }}</strong> {{ $barang->satuan ?? 'unit' }}
                                            @if($barang->jumlah < 5)
                                                <span class="badge bg-danger ms-2"><i class='bx bx-error-circle'></i> Stok Rendah</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <!-- Additional Info -->
                        <h6 class="mb-3"><i class='bx bx-info-circle me-2'></i>Informasi Tambahan</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 45%">Tanggal Beli</td>
                                        <td>
                                            @if($barang->tanggal_beli)
                                                {{ \Carbon\Carbon::parse($barang->tanggal_beli)->format('d M Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Harga</td>
                                        <td>
                                            @if($barang->harga)
                                                <strong>Rp {{ number_format($barang->harga, 0, ',', '.') }}</strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 45%">Dibuat</td>
                                        <td><small>{{ $barang->created_at->format('d M Y H:i') }}</small></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Diperbarui</td>
                                        <td><small>{{ $barang->updated_at->format('d M Y H:i') }}</small></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($barang->deskripsi)
                            <hr>
                            <h6 class="mb-2"><i class='bx bx-detail me-2'></i>Deskripsi</h6>
                            <p class="text-muted">{{ $barang->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Peminjaman History -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class='bx bx-history me-2'></i>Riwayat Peminjaman</h6>
                    </div>
                    <div class="card-body">
                        @if(isset($barang->peminjaman) && $barang->peminjaman->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($barang->peminjaman->take(5) as $p)
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <a href="{{ route('peminjaman.show', $p->id) }}" class="text-decoration-none">
                                                    <strong>{{ $p->nama_peminjam }}</strong>
                                                </a>
                                                <div class="small text-muted">{{ $p->kode_peminjaman }}</div>
                                                <div class="small text-muted">
                                                    <i class='bx bx-calendar'></i> {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                                                </div>
                                            </div>
                                            <span class="badge 
                                                @if($p->status === 'dipinjam') bg-warning
                                                @elseif($p->status === 'dikembalikan') bg-success
                                                @else bg-danger
                                                @endif">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            @if($barang->peminjaman->count() > 5)
                                <div class="mt-2 text-center">
                                    <small class="text-muted">+{{ $barang->peminjaman->count() - 5 }} peminjaman lainnya</small>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class='bx bx-history bx-lg text-muted mb-2 d-block'></i>
                                <p class="text-muted mb-0">Belum ada riwayat peminjaman</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class='bx bx-cog me-2'></i>Aksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-edit" data-id="{{ $barang->id }}">
                                <i class='bx bx-edit'></i> Edit Barang
                            </a>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="form-delete" data-nama="{{ $barang->nama_barang }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class='bx bx-trash'></i> Hapus Barang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi SweetAlert2 Toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            // Tampilkan notifikasi sukses jika ada
            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            @endif

            // Konfirmasi edit barang
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    const id = this.getAttribute('data-id');
                    
                    Swal.fire({
                        title: 'Edit Data Barang',
                        text: 'Anda akan mengedit data barang ini. Lanjutkan?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#ffab00',
                        cancelButtonColor: '#8592a3',
                        confirmButtonText: 'Ya, Edit',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });

            // Konfirmasi hapus barang
            document.querySelectorAll('.form-delete').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    const namaBarang = this.getAttribute('data-nama');
                    
                    Swal.fire({
                        title: 'Hapus Data Barang',
                        html: `Apakah Anda yakin ingin menghapus <strong>${namaBarang}</strong>?<br><span class="text-danger">Data yang dihapus tidak dapat dikembalikan!</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#8592a3',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection