@extends('layouts.dashboard')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f0f2f9; }

    /* Header Positioning */
    .premium-header {
        background: linear-gradient(135deg, #00b894 0%, #006266 100%);
        padding: 3rem 2rem 3rem 2rem;
        border-radius: 30px;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 15px 35px rgba(0, 184, 148, 0.25);
        position: relative;
        z-index: 1;
    }

    /* Container Overlay */
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
        margin-top: 2rem;
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

    .avatar-shape {
        width: 45px; height: 45px;
        background: #e1fcef;
        color: #00b894;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
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

    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="premium-header d-md-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-bold text-white mb-2" style="font-weight: 800;"><i class="bx bx-map-pin me-2"></i>Daftar Lokasi</h2>
            <p class="text-white-50 mb-0">Kelola titik penyimpanan dan distribusi aset Anda.</p>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
            <a href="{{ route('lokasi.create') }}" class="btn btn-white shadow-sm px-4" style="border-radius: 12px; background: white; color: #00b894; font-weight: 700;">
                <i class="bx bx-plus-circle me-1"></i> Tambah Lokasi
            </a>
        </div>
    </div>

    <div class="content-wrapper-overlay">
        <div class="row">
            <div class="col-md-4">
                <div class="mini-card d-flex align-items-center">
                    <div class="icon-shape me-3" style="background: #e1fcef; color: #00b894; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="bx bx-buildings"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $lokasi->count() }}</h4>
                        <small class="text-muted">Total Lokasi</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card main-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="lokasiTable">
                        <thead>
                            <tr>
                                <th width="30%">Nama Lokasi</th>
                                <th width="40%">Deskripsi</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lokasi as $l)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-shape me-3">
                                            {{ strtoupper(substr($l->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $l->nama }}</div>
                                            <small class="text-muted">ID: LOC-{{ str_pad($l->id, 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary small">
                                        {{ Str::limit($l->deskripsi, 80) ?: 'Tidak ada deskripsi lokasi.' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-label-success badge-status">AKTIF</span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('lokasi.edit', $l->id) }}" class="btn-action btn-edit" title="Edit">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                        <form action="{{ route('lokasi.destroy', $l->id) }}" method="POST" class="m-0">
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
        $('#lokasiTable').DataTable({
            "dom": '<"d-flex justify-content-between align-items-center mb-4"lf>rt<"d-flex justify-content-between align-items-center mt-4"ip>',
            "language": {
                "search": "",
                "searchPlaceholder": "Cari lokasi...",
                "lengthMenu": "_MENU_ baris",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "next": '<i class="bx bx-chevron-right"></i>',
                    "previous": '<i class="bx bx-chevron-left"></i>'
                }
            }
        });
    }

    // 2. Perbaiki Konfirmasi Hapus dengan Event Delegation
    $(document).on('click', '.btn-delete-confirm', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        
        Swal.fire({
            title: 'Hapus data?',
            text: "Lokasi ini akan dihapus permanen!",
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

    // 3. Notifikasi Sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            background: '#fff',
            iconColor: '#00b894'
        });
    @endif
});
</script>
@endpush