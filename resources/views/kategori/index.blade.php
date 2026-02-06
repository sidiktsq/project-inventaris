@extends('layouts.dashboard')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f0f2f9; }

    /* Header dengan Padding Bawah Ekstra untuk Ruang Overlap */
    .premium-header {
        background: linear-gradient(135deg, #696cff 0%, #30336b 100%);
        padding: 3rem 2rem 3rem 2rem; /* Sesuaikan padding */
        border-radius: 30px;
        color: white;
        margin-bottom: 2rem; /* Beri jarak positif, bukan overlap */
        box-shadow: 0 15px 35px rgba(105, 108, 255, 0.25);
        position: relative;
        z-index: 1;
    }

    /* Container Konten Utama agar di atas Header */
    .content-wrapper-overlay {
        position: relative;
        z-index: 2;
        padding: 0 1rem;
    }

    .mini-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }
    .mini-card:hover { transform: translateY(-5px); }

    .main-card {
        background: #ffffff;
        border-radius: 25px;
        border: none;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        margin-top: 2rem; /* Jarak antara Stats dan Tabel */
    }

    /* Table Adjustments */
    .table thead th {
        background-color: #f8faff !important;
        color: #566a7f !important;
        padding: 1rem !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    .btn-action {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
    }
    .btn-edit { background: #e7e7ff; color: #696cff; }
    .btn-edit:hover { background: #696cff; color: white; }
    
    .btn-delete { background: #ffe5e0; color: #ff3e1d; }
    .btn-delete:hover { background: #ff3e1d; color: white; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="premium-header d-md-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-bold text-white mb-2" style="font-weight: 800;">📦 Master Kategori</h2>
            <p class="text-white-50 mb-0">Kelola klasifikasi aset barang Anda dengan sistematis.</p>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
            <a href="{{ route('kategori.create') }}" class="btn btn-white shadow-sm px-4" style="border-radius: 12px; background: white; color: #696cff; font-weight: 700;">
                <i class="bx bx-plus-circle me-1"></i> Tambah Kategori
            </a>
            <button class="btn btn-danger shadow-sm" style="border-radius: 12px;">
                <i class="bx bxs-file-pdf"></i>
            </button>
        </div>
    </div>

    <div class="content-wrapper-overlay">
        <div class="row">
            <div class="col-md-4">
                <div class="mini-card d-flex align-items-center">
                    <div class="icon-shape me-3" style="background: #f0f2ff; color: #696cff; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="bx bx-grid-alt"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $kategoris->count() }}</h4>
                        <small class="text-muted">Total Kategori</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card main-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="kategoriTable">
                        <thead>
                            <tr>
                                <th width="30%">Nama Kategori</th>
                                <th width="50%">Deskripsi</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoris as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-letter me-3" style="width: 40px; height: 40px; background: #696cff; color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                            {{ strtoupper(substr($item->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                            <small class="text-muted">#ID-{{ $item->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary small">
                                        {{ Str::limit($item->deskripsi, 80) ?: 'Tidak ada deskripsi.' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('kategori.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="m-0">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn-action btn-delete btn-delete-confirm" title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTables
    if ($.fn.DataTable) {
        $('#kategoriTable').DataTable({
            "dom": '<"d-flex justify-content-between align-items-center mb-4"lf>rt<"d-flex justify-content-between align-items-center mt-4"ip>',
            "language": {
                "search": "",
                "searchPlaceholder": "Cari kategori...",
                "lengthMenu": "_MENU_ baris",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "next": '<i class="bx bx-chevron-right"></i>',
                    "previous": '<i class="bx bx-chevron-left"></i>'
                }
            }
        });
    }

    // 2. Perbaiki Konfirmasi Hapus dengan Event Delegation (agar jalan di DataTables)
    $(document).on('click', '.btn-delete-confirm', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        
        Swal.fire({
            title: 'Hapus data?',
            text: "Kategori ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush