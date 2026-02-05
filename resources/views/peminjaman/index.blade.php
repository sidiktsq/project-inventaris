@extends('layouts.dashboard')
@section('title', 'Daftar Peminjaman')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Daftar Peminjaman</h4>
            <p class="text-muted small mb-0">Manajemen data transaksi peminjaman barang dan aset.</p>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary shadow-sm px-4">
            <i class="bx bx-plus-circle me-2"></i> Tambah Transaksi
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold text-dark">Data Transaksi</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0 text-uppercase small fw-bold">Kode</th>
                        <th class="border-0 text-uppercase small fw-bold">Peminjam</th>
                        <th class="border-0 text-uppercase small fw-bold">Barang</th>
                        <th class="border-0 text-uppercase small fw-bold text-center">Periode</th>
                        <th class="border-0 text-uppercase small fw-bold text-center">Status</th>
                        <th class="border-0 text-uppercase small fw-bold text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($peminjamans as $p)
                    <tr class="transition-all">
                        <td class="ps-4">
                            <span class="badge bg-label-dark rounded-pill fw-bold">#{{ $p->kode_peminjaman }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary">{{ substr($p->nama_peminjam, 0, 1) }}</span>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $p->nama_peminjam }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ ucfirst($p->jenis_peminjam) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @foreach($p->details as $detail)
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge badge-dot bg-primary me-2"></span>
                                <span class="text-dark small fw-medium">{{ $detail->barang->nama_barang }} (x{{ $detail->jumlah }})</span>
                            </div>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <div class="small">
                                <span class="text-success">{{ $p->tanggal_pinjam }}</span><br>
                                <span class="text-danger">{{ $p->tanggal_kembali }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            @php
                                $statusStyle = [
                                    'dipinjam' => 'bg-label-warning',
                                    'dikembalikan' => 'bg-label-success',
                                    'terlambat' => 'bg-label-danger'
                                ];
                            @endphp
                            <span class="badge {{ $statusStyle[$p->status] ?? 'bg-label-secondary' }} px-3">
                                {{ strtoupper($p->status) }}
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="{{ route('peminjaman.show', $p->id) }}" class="btn btn-sm btn-icon btn-label-info action-btn" data-bs-toggle="tooltip" title="Detail">
                                    <i class="bx bx-show-alt"></i>
                                </a>

                                <a href="{{ route('peminjaman.edit', $p->id) }}" class="btn btn-sm btn-icon btn-label-warning action-btn btn-edit" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bx bx-edit-alt"></i>
                                </a>

                                <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-icon btn-label-danger action-btn btn-delete" data-bs-toggle="tooltip" title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Style sama seperti sebelumnya agar konsisten */
    .transition-all { transition: all 0.3s ease; }
    .btn-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px !important; border: none; }
    .btn-label-info { background-color: #e7f7ff !important; color: #03c3ec !important; }
    .btn-label-warning { background-color: #fff8e1 !important; color: #ffab00 !important; }
    .btn-label-danger { background-color: #ffeef3 !important; color: #ff3e1d !important; }
    .action-btn { transition: all 0.2s ease-in-out; }
    .action-btn:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); color: #fff !important; }
    .btn-label-info:hover { background-color: #03c3ec !important; }
    .btn-label-warning:hover { background-color: #ffab00 !important; }
    .btn-label-danger:hover { background-color: #ff3e1d !important; }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // 1. Inisialisasi Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el) });

        // 2. SweetAlert untuk Konfirmasi Hapus
        $('.btn-delete').on('click', function(e) {
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
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

        // 3. SweetAlert untuk Konfirmasi Edit (Opsional, memberikan kesan hati-hati)
        $('.btn-edit').on('click', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            Swal.fire({
                title: 'Edit Data?',
                text: "Anda akan diarahkan ke halaman pengeditan.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                confirmButtonText: 'Lanjutkan',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        // 4. Notifikasi Sukses dari Session (Jika controller mengirim success message)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false,
                customClass: {
                    popup: 'animate__animated animate__fadeInDown'
                }
            });
        @endif
    });
</script>
@endpush
@endsection