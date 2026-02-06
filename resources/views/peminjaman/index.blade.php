@extends('layouts.dashboard')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f0f2f9; }

    /* Premium Header */
    .premium-header {
        background: linear-gradient(135deg, #696cff 0%, #30336b 100%);
        padding: 3rem 2rem;
        border-radius: 30px;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 15px 35px rgba(105, 108, 255, 0.25);
    }

    /* Stats Cards */
    .stat-card-modern {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: #ffffff;
    }
    .stat-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    /* Table & Card */
    .main-card {
        background: #ffffff;
        border-radius: 25px;
        border: none;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }
    
    .table thead th {
        background: #f8f9fa;
        color: #566a7f;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border: none;
        padding: 1rem;
    }

    /* Action Buttons Style */
    .btn-action {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
    }
    .btn-detail { background: #e7e7ff; color: #696cff; }
    .btn-detail:hover { background: #696cff; color: white; }
    .btn-edit { background: #fff2e2; color: #fdac41; }
    .btn-edit:hover { background: #fdac41; color: white; }
    .btn-delete { background: #ffe5e5; color: #ff3e1d; }
    .btn-delete:hover { background: #ff3e1d; color: white; }

    /* Badges */
    .badge-modern {
        padding: 0.6rem 1rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.75rem;
    }
    .status-dipinjam { background: #fff2d6 !important; color: #ffab00 !important; }
    .status-dikembalikan { background: #e8fadf !important; color: #71dd37 !important; }
    .status-terlambat { background: #ffe5e0 !important; color: #ff3e1d !important; }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d9dee3;
        border-radius: 0.5rem;
        padding: 0.4375rem 0.875rem;
        margin-left: 0.5rem;
    }
    .paginate_button.page-item.active .page-link {
        background-color: #696cff !important;
        border-color: #696cff !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Section -->
    <div class="premium-header d-md-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold text-white mb-2" style="font-weight: 800;">📄 Peminjaman</h2>
            <p class="text-white-50 mb-0">Kelola sirkulasi aset dan inventaris dengan efisien.</p>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
            <a href="{{ route('peminjaman.create') }}" class="btn px-4 shadow-sm" style="border-radius: 12px; background: white; color: #696cff; font-weight: 700;">
                <i class="bx bx-plus-circle me-1"></i> Tambah Pinjam
            </a>
            <div class="dropdown">
                <button class="btn btn-dark px-4 shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" style="border-radius: 12px;">
                    <i class="bx bx-export me-1"></i> Export
                </button>
                <ul class="dropdown-menu border-0 shadow-lg" style="border-radius: 15px;">
                    <li><a class="dropdown-item py-2" href="{{ route('peminjaman.export.excel') }}"><i class='bx bx-spreadsheet me-2 text-success'></i> Excel</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('peminjaman.export.pdf') }}"><i class='bx bxs-file-pdf me-2 text-danger'></i> PDF</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-modern shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small uppercase fw-bold">Total Pinjam</p>
                            <h3 class="mb-0 fw-black text-dark">{{ $peminjamans->count() }}</h3>
                        </div>
                        <div class="avatar bg-label-primary p-2 rounded-3">
                            <i class="bx bx-list-ul fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-modern shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small uppercase fw-bold">Sedang Dipinjam</p>
                            <h3 class="mb-0 fw-black text-warning">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</h3>
                        </div>
                        <div class="avatar bg-label-warning p-2 rounded-3">
                            <i class="bx bx-time fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-modern shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small uppercase fw-bold">Dikembalikan</p>
                            <h3 class="mb-0 fw-black text-success">{{ \App\Models\Peminjaman::where('status', 'dikembalikan')->count() }}</h3>
                        </div>
                        <div class="avatar bg-label-success p-2 rounded-3">
                            <i class="bx bx-check-circle fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-modern shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small uppercase fw-bold">Terlambat</p>
                            <h3 class="mb-0 fw-black text-danger">{{ \App\Models\Peminjaman::where('status', 'terlambat')->count() }}</h3>
                        </div>
                        <div class="avatar bg-label-danger p-2 rounded-3">
                            <i class="bx bx-error-circle fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Section -->
    <div class="card main-card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 15px;">
                    <i class='bx bx-check-circle me-2'></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tablePeminjaman">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Kode & Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status Kembali</th>
                            <th>Status</th>
                            <th>Petugas</th>
                            <th class="text-center" style="width: 150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamans as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $p->nama_peminjam }}</span>
                                    <small class="text-primary fw-semibold">{{ $p->kode_peminjaman }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="small"><i class='bx bx-calendar me-1'></i> {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    @if($p->tanggal_kembali)
                                        <span class="small text-success fw-semibold"><i class='bx bx-calendar-check me-1'></i> {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}</span>
                                    @else
                                        <span class="small text-danger fw-bold"><i class='bx bx-time-five me-1'></i> Belum Kembali</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'dipinjam' => 'status-dipinjam',
                                        'dikembalikan' => 'status-dikembalikan',
                                        'terlambat' => 'status-terlambat'
                                    ][$p->status] ?? 'bg-label-secondary';
                                @endphp
                                <span class="badge badge-modern {{ $statusClass }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="small text-muted"><i class='bx bx-user-circle me-1'></i> {{ optional($p->user)->name ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('peminjaman.show', $p->id) }}" class="btn-action btn-detail" title="Detail">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" class="m-0 form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete btn-delete-confirm" title="Hapus">
                                            <i class='bx bx-trash'></i>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // DataTables
        if ($.fn.DataTable) {
            $('#tablePeminjaman').DataTable({
                "dom": '<"d-flex justify-content-between align-items-center mb-4"lf>rt<"d-flex justify-content-between align-items-center mt-4"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Cari data peminjaman...",
                    "lengthMenu": "_MENU_",
                    "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                    "paginate": {
                        "next": '<i class="bx bx-chevron-right"></i>',
                        "previous": '<i class="bx bx-chevron-left"></i>'
                    }
                }
            });
        }

        // Delete Confirmation
        $(document).on('click', '.btn-delete-confirm', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            
            Swal.fire({
                title: 'Hapus data?',
                text: "Data peminjaman ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection