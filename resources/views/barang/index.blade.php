@extends('layouts.dashboard')

@section('content')
<style>
    /* Custom Modern Properties */
    :root {
        --primary-glow: rgba(105, 108, 255, 0.4);
        --glass-bg: rgba(255, 255, 255, 0.85);
    }

    /* Elegant Background Gradients */
    .bg-gradient-primary { background: linear-gradient(135deg, #696cff 0%, #8e91ff 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #71dd37 0%, #96e66c 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #ffab00 0%, #ffc145 100%); }
    .bg-gradient-danger  { background: linear-gradient(135deg, #ff3e1d 0%, #ff6e56 100%); }

    /* Glassmorphism Refined */
    .card {
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 30px 0 rgba(41, 51, 80, 0.08);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px 0 rgba(41, 51, 80, 0.12) !important;
    }

    /* Icon Glow Effect */
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .stat-icon::after {
        content: '';
        position: absolute;
        width: 100%; height: 100%;
        background: inherit;
        filter: blur(10px);
        opacity: 0.4;
        z-index: -1;
        border-radius: 18px;
    }

    /* Table Sophistication */
    .table-container {
        border-radius: 20px;
    }
    
    .table thead th {
        background-color: rgba(245, 246, 250, 0.5);
        color: #566a7f;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 1.5rem 1rem;
        border-bottom: none;
    }

    .table tbody tr {
        transition: all 0.2s;
    }

    .table tbody tr:hover {
        background-color: rgba(105, 108, 255, 0.03);
    }

    /* Floating Action Button Style */
    .btn-primary {
        box-shadow: 0 4px 15px 0 var(--primary-glow);
        border: none;
        background: linear-gradient(45deg, #696cff, #8e91ff);
    }

    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px 0 var(--primary-glow);
    }

    /* Soft Badges */
    .badge-soft-success { background-color: #e8fadf; color: #71dd37; border: 1px solid rgba(113, 221, 55, 0.2); }
    .badge-soft-warning { background-color: #fff2d6; color: #ffab00; border: 1px solid rgba(255, 171, 0, 0.2); }
    .badge-soft-danger  { background-color: #ffe5e0; color: #ff3e1d; border: 1px solid rgba(255, 62, 29, 0.2); }
    .badge-soft-info    { background-color: #e7e7ff; color: #696cff; border: 1px solid rgba(105, 108, 255, 0.2); }

    /* Custom Search Focus */
    .form-control-custom {
        border-radius: 12px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: 0.3s;
    }

    .form-control-custom:focus {
        background: #fff;
        border-color: #696cff;
        box-shadow: 0 0 0 4px rgba(105, 108, 255, 0.1);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-muted">App</a></li>
                    <li class="breadcrumb-item active text-primary">Inventory</li>
                </ol>
            </nav>
            <h3 class="fw-extra-bold mb-0" style="letter-spacing: -1px;">Dashboard Inventaris ✨</h3>
        </div>
        <a href="{{ route('barang.create') }}" class="btn btn-primary btn-lg px-4 rounded-pill d-flex align-items-center">
            <i class='bx bx-plus-circle fs-4 me-2'></i> 
            <span class="fw-bold">Barang Baru</span>
        </a>
    </div>

    <div class="row mb-5">
        @php
            $stats = [
                ['Total Barang', $barang->total(), 'bx-package', 'primary'],
                ['Kondisi Baik', $barang->where('kondisi', 'baik')->count(), 'bx-check-shield', 'success'],
                ['Perbaikan', $barang->whereIn('kondisi', ['rusak_ringan', 'rusak_berat'])->count(), 'bx-wrench', 'warning'],
                ['Stok Rendah', $barang->where('jumlah', '<', 5)->count(), 'bx-trending-down', 'danger']
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted fw-medium mb-1">{{ $stat[0] }}</p>
                            <h2 class="mb-0 fw-bold text-dark">{{ $stat[1] }}</h2>
                        </div>
                        <div class="stat-icon bg-gradient-{{ $stat[3] }} text-white">
                            <i class='bx {{ $stat[2] }} fs-2'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header border-bottom bg-transparent py-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text border-0 bg-light"><i class='bx bx-search text-muted'></i></span>
                        <input type="text" id="searchInput" class="form-control form-control-custom border-0 bg-light" placeholder="Cari aset Anda...">
                    </div>
                </div>
                <div class="col-md-8 text-md-end">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <select class="form-select form-select-custom w-auto border-0 bg-light rounded-pill">
                            <option value="">Semua Kategori</option>
                        </select>
                        <button class="btn btn-light rounded-pill px-4">
                            <i class='bx bx-filter-alt me-1'></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="ps-4">Item & Spesifikasi</th>
                        <th>Kategori</th>
                        <th>Status Kondisi</th>
                        <th>Ketersediaan</th>
                        <th class="text-center pe-4">Manajemen</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="table-barang-body">
                    @forelse($barang as $b)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-wrapper me-3">
                                    @if($b->foto)
                                        <img src="{{ asset('storage/' . $b->foto) }}" class="rounded-circle shadow-sm" style="width:48px; height:48px; object-fit:cover; border: 2px solid #fff;">
                                    @else
                                        <div class="bg-label-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:48px; height:48px;">
                                            <i class='bx bx-cube fs-4'></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="fw-bold d-block text-dark fs-6">{{ $b->nama_barang }}</span>
                                    <span class="badge bg-label-secondary small" style="font-size: 0.7rem;">ID: {{ $b->kode_barang }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class='bx bx-folder text-primary me-2'></i>
                                <span class="text-muted fw-medium">{{ optional($b->kategori)->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusMap = [
                                    'baik' => ['class' => 'badge-soft-success', 'icon' => 'bxs-check-circle'],
                                    'rusak_ringan' => ['class' => 'badge-soft-warning', 'icon' => 'bxs-error'],
                                    'rusak_berat' => ['class' => 'badge-soft-danger', 'icon' => 'bxs-x-circle']
                                ];
                                $st = $statusMap[$b->kondisi] ?? ['class' => 'bg-label-info', 'icon' => 'bxs-info-circle'];
                            @endphp
                            <span class="badge {{ $st['class'] }} rounded-pill px-3 py-2">
                                <i class='bx {{ $st['icon'] }} me-1'></i> {{ ucwords(str_replace('_', ' ', $b->kondisi)) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold {{ $b->jumlah < 5 ? 'text-danger' : 'text-dark' }}">{{ $b->jumlah }} {{ $b->satuan ?? 'Unit' }}</span>
                                <div class="progress mt-1" style="height: 4px; width: 80px;">
                                    <div class="progress-bar {{ $b->jumlah < 5 ? 'bg-danger' : 'bg-primary' }}" role="progressbar" style="width: {{ min(($b->jumlah/100)*100, 100) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('barang.show', $b->id) }}" class="btn btn-icon btn-sm rounded-circle btn-outline-info" title="Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                                <a href="{{ route('barang.edit', $b->id) }}" class="btn btn-icon btn-sm rounded-circle btn-outline-warning" title="Edit">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <form action="{{ route('barang.destroy', $b->id) }}" method="POST" class="d-inline m-0 form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-icon btn-sm rounded-circle btn-outline-danger btn-delete-confirm" title="Hapus">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class='bx bx-package fs-1 d-block mb-2'></i>
                            Belum ada data barang.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($barang->hasPages())
            <div class="card-footer border-top bg-transparent py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $barang->firstItem() }} - {{ $barang->lastItem() }} dari {{ $barang->total() }} data
                    </div>
                    <div>{{ $barang->links('pagination::bootstrap-5') }}</div>
                </div>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Konfigurasi SweetAlert Toast
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

    // 3. Notifikasi Sukses
    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}"
        });
    @endif

    // 4. Notifikasi Gagal/Error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            confirmButtonColor: '#696cff'
        });
    @endif

    // 4. Konfirmasi Hapus
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete-confirm')) {
            const button = e.target.closest('.btn-delete-confirm');
            const form = button.closest('form');
            
            Swal.fire({
                title: 'Hapus barang ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger px-4',
                    cancelButton: 'btn btn-label-secondary px-4'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                    button.disabled = true;
                    form.submit();
                }
            });
        }
    });

    // 5. Pencarian Live (Client Side)
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            const rows = document.querySelectorAll('#table-barang-body tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection