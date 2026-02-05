@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class='bx bx-package bx-sm'></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block mb-1">Total Barang</span>
                            <h4 class="card-title mb-0">{{ $barang->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class='bx bx-check-circle bx-sm'></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block mb-1">Kondisi Baik</span>
                            <h4 class="card-title mb-0">{{ $barang->where('kondisi', 'baik')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class='bx bx-error bx-sm'></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block mb-1">Perlu Perbaikan</span>
                            <h4 class="card-title mb-0">{{ $barang->whereIn('kondisi', ['rusak_ringan', 'rusak_berat'])->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class='bx bx-error-circle bx-sm'></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block mb-1">Stok Rendah</span>
                            <h4 class="card-title mb-0">{{ $barang->where('jumlah', '<', 5)->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class='bx bx-package me-2'></i>Daftar Barang</h5>
            <a href="{{ route('barang.create') }}" class="btn btn-primary">
                <i class='bx bx-plus me-1'></i>Tambah Barang
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class='bx bx-check-circle me-2'></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Search & Filter -->
            <div class="row mb-3">
                <div class="col-md-4 mb-2">
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-search'></i></span>
                        <input type="text" class="form-control" id="searchBarang" placeholder="Cari nama atau kode barang...">
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <select class="form-select" id="filterKategori">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\Kategori::all() as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select class="form-select" id="filterKondisi">
                        <option value="">Semua Kondisi</option>
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                        <option value="hilang">Hilang</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class='bx bx-reset'></i> Reset
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableBarang">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px">#</th>
                            <th style="width: 80px">Foto</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th>Jumlah</th>
                            <th style="width: 200px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $i => $b)
                            <tr>
                                <td>{{ $barang->firstItem() + $i }}</td>
                                <td>
                                    @if($b->foto)
                                        <img src="{{ asset('storage/' . $b->foto) }}" alt="{{ $b->nama_barang }}"
                                            class="rounded border" style="width:60px; height:60px; object-fit:cover;" />
                                    @else
                                        <div class="avatar avatar-md">
                                            <span class="avatar-initial rounded bg-label-secondary">
                                                <i class='bx bx-image'></i>
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td><span class="badge bg-label-dark">{{ $b->kode_barang }}</span></td>
                                <td><strong>{{ $b->nama_barang }}</strong></td>
                                <td>
                                    <span class="badge bg-label-primary">
                                        <i class='bx bx-category-alt'></i> {{ optional($b->kategori)->nama ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">
                                        <i class='bx bx-map'></i> {{ optional($b->lokasi)->nama ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($b->kondisi == 'baik')
                                        <span class="badge bg-success"><i class='bx bx-check-circle'></i> Baik</span>
                                    @elseif($b->kondisi == 'rusak_ringan')
                                        <span class="badge bg-warning"><i class='bx bx-error'></i> Rusak Ringan</span>
                                    @elseif($b->kondisi == 'rusak_berat')
                                        <span class="badge bg-danger"><i class='bx bx-x-circle'></i> Rusak Berat</span>
                                    @elseif($b->kondisi == 'hilang')
                                        <span class="badge bg-secondary"><i class='bx bx-help-circle'></i> Hilang</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ number_format($b->jumlah) }}</strong> {{ $b->satuan ?? 'unit' }}
                                    @if($b->jumlah < 5)
                                        <br><small class="text-danger"><i class='bx bx-error-circle'></i> Stok rendah</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('barang.show', $b->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        <a href="{{ route('barang.edit', $b->id) }}" class="btn btn-sm btn-warning btn-edit" title="Edit" data-id="{{ $b->id }}">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                        <form action="{{ route('barang.destroy', $b->id) }}" method="POST" class="form-delete" data-nama="{{ $b->nama_barang }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class='bx bx-package bx-lg text-muted mb-2 d-block'></i>
                                    <p class="text-muted mb-2">Belum ada data barang.</p>
                                    <a href="{{ route('barang.create') }}" class="btn btn-sm btn-primary">
                                        <i class='bx bx-plus me-1'></i>Tambah Barang Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $barang->firstItem() ?? 0 }} - {{ $barang->lastItem() ?? 0 }} dari {{ $barang->total() }} data
                </div>
                <div>
                    {{ $barang->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

<!-- Simple Filter Script -->
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
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
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

        // Filter table
        const searchInput = document.getElementById('searchBarang');
        const filterKategori = document.getElementById('filterKategori');
        const filterKondisi = document.getElementById('filterKondisi');
        const table = document.getElementById('tableBarang');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const kategoriValue = filterKategori.value;
            const kondisiValue = filterKondisi.value;

            for (let row of rows) {
                if (row.cells.length === 1) continue; // Skip empty state row

                const kode = row.cells[2].textContent.toLowerCase();
                const nama = row.cells[3].textContent.toLowerCase();
                const kategori = row.cells[4].textContent.toLowerCase();
                const kondisi = row.cells[6].textContent.toLowerCase();

                const matchSearch = kode.includes(searchTerm) || nama.includes(searchTerm);
                const matchKategori = !kategoriValue || 
                    (filterKategori.options[filterKategori.selectedIndex] && 
                     kategori.includes(filterKategori.options[filterKategori.selectedIndex].text.toLowerCase()));
                const matchKondisi = !kondisiValue || kondisi.includes(kondisiValue);

                row.style.display = (matchSearch && matchKategori && matchKondisi) ? '' : 'none';
            }
        }

        searchInput.addEventListener('keyup', filterTable);
        filterKategori.addEventListener('change', filterTable);
        filterKondisi.addEventListener('change', filterTable);
    });

    function resetFilters() {
        document.getElementById('searchBarang').value = '';
        document.getElementById('filterKategori').value = '';
        document.getElementById('filterKondisi').value = '';
        
        const table = document.getElementById('tableBarang');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        for (let row of rows) {
            row.style.display = '';
        }
    }
</script>
@endsection