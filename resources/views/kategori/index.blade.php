@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Styling Elegan Custom */
    .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    .table thead th { 
        background-color: #f8f9fa; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 1px; 
        font-weight: 700;
        border: none;
    }
    .avatar-initial {
        width: 38px; height: 38px;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; transition: 0.3s;
    }
    /* Action Buttons Icon Style */
    .btn-action {
        width: 35px; height: 35px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 10px; transition: all 0.3s;
        margin: 0 2px;
    }
    .btn-edit { background: #e7e7ff; color: #696cff; }
    .btn-edit:hover { background: #696cff; color: #fff; transform: translateY(-2px); }
    
    .btn-delete { background: #ffe0db; color: #ff3e1d; }
    .btn-delete:hover { background: #ff3e1d; color: #fff; transform: translateY(-2px); }

    /* Merapikan DataTables bawah */
    .dataTables_info { font-size: 0.85rem; padding-left: 1.5rem; }
    .dataTables_paginate { padding-right: 1.5rem; padding-top: 1rem; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Sistem /</span> Daftar Kategori
        </h4>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary shadow-sm px-4">
            <i class="bx bx-plus-circle me-1"></i> Tambah Kategori
        </a>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive px-3 py-3">
            <table class="table table-hover" id="kategoriTable">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="fw-bold text-dark">{{ $item->nama }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted">{{ Str::limit($item->deskripsi, 40) ?: '-' }}</span>
                        </td>
                        <td>
                           @if($item->status == 1)
                                <span class="badge bg-success">AKTIF</span>
                            @else
                                <span class="badge bg-danger">TIDAK AKTIF</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('kategori.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                                
                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="delete-form">
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
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTables (Agar muncul Search & Showing Entries)
    $('#kategoriTable').DataTable({
        "language": {
            "search": "",
            "searchPlaceholder": "Cari kategori...",
            "lengthMenu": "_MENU_",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "paginate": {
                "next": '<i class="bx bx-chevron-right"></i>',
                "previous": '<i class="bx bx-chevron-left"></i>'
            }
        },
        "dom": '<"row mx-1"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row mx-1"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    });

    // 2. SweetAlert2 Notifikasi Sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            background: '#fff',
            iconColor: '#696cff'
        });
    @endif

    // 3. SweetAlert2 Konfirmasi Hapus
    $(document).on('click', '.btn-delete-confirm', function(e) {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#696cff',
            cancelButtonColor: '#ff3e1d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush