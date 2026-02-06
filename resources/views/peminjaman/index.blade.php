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
                                    <i class='bx bx-list-ul bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block mb-1">Total Peminjaman</span>
                                <h4 class="card-title mb-0">{{ $peminjamans->count() }}</h4>
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
                                    <i class='bx bx-time bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block mb-1">Sedang Dipinjam</span>
                                <h4 class="card-title mb-0">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</h4>
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
                                <span class="d-block mb-1">Dikembalikan</span>
                                <h4 class="card-title mb-0">{{ \App\Models\Peminjaman::where('status', 'dikembalikan')->count() }}</h4>
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
                                <span class="d-block mb-1">Terlambat</span>
                                <h4 class="card-title mb-0">{{ \App\Models\Peminjaman::where('status', 'terlambat')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class='bx bx-list-ul me-2'></i>Daftar Peminjaman</h5>
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                    <i class='bx bx-plus me-1'></i>Tambah Peminjaman
                </a>
                <div class="ms-2">
                    <a href="{{ route('peminjaman.export.excel') }}" class="btn btn-success" target="_blank">
                        <i class='bx bx-spreadsheet me-1'></i>Export Excel
                    </a>
                    <a href="{{ route('peminjaman.export.pdf') }}" class="btn btn-danger" target="_blank">
                        <i class='bx bxs-file-pdf me-1'></i>Export PDF
                    </a>
                </div>
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
                            <input type="text" class="form-control" id="searchPeminjaman" placeholder="Cari nama peminjam atau kode...">
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="dikembalikan">Dikembalikan</option>
                            <option value="terlambat">Terlambat</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" class="form-control" id="filterTanggal" placeholder="Filter tanggal">
                    </div>
                    <div class="col-md-2 mb-2">
                        <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                            <i class='bx bx-reset'></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tablePeminjaman">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>Kode</th>
                                <th>Nama Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans as $i => $p)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><span class="badge bg-label-dark">{{ $p->kode_peminjaman }}</span></td>
                                    <td><strong>{{ $p->nama_peminjam }}</strong></td>
                                    <td>
                                        <i class='bx bx-calendar'></i> {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                                    </td>
                                    <td>
                                        @if($p->tanggal_kembali)
                                            <i class='bx bx-calendar-check'></i> {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->status === 'dipinjam')
                                            <span class="badge bg-warning"><i class='bx bx-time'></i> Dipinjam</span>
                                        @elseif($p->status === 'dikembalikan')
                                            <span class="badge bg-success"><i class='bx bx-check-circle'></i> Dikembalikan</span>
                                        @elseif($p->status === 'terlambat')
                                            <span class="badge bg-danger"><i class='bx bx-error-circle'></i> Terlambat</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($p->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <i class='bx bx-user'></i> {{ optional($p->user)->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('peminjaman.show', $p->id) }}" class="btn btn-sm btn-info" title="Detail">
                                                <i class='bx bx-show'></i>
                                            </a>
                                            <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?');" class="mb-0">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class='bx bx-list-ul bx-lg text-muted mb-2 d-block'></i>
                                        <p class="text-muted mb-2">Belum ada data peminjaman.</p>
                                        <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-primary">
                                            <i class='bx bx-plus me-1'></i>Tambah Peminjaman Pertama
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
                        Menampilkan data peminjaman
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchPeminjaman');
            const filterStatus = document.getElementById('filterStatus');
            const filterTanggal = document.getElementById('filterTanggal');
            const table = document.getElementById('tablePeminjaman');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = filterStatus.value.toLowerCase();
                const tanggalValue = filterTanggal.value;

                for (let row of rows) {
                    if (row.cells.length === 1) continue;

                    const kode = row.cells[1].textContent.toLowerCase();
                    const nama = row.cells[2].textContent.toLowerCase();
                    const tanggal = row.cells[3].textContent;
                    const status = row.cells[5].textContent.toLowerCase();

                    const matchSearch = kode.includes(searchTerm) || nama.includes(searchTerm);
                    const matchStatus = !statusValue || status.includes(statusValue);
                    const matchTanggal = !tanggalValue || tanggal.includes(tanggalValue);

                    row.style.display = (matchSearch && matchStatus && matchTanggal) ? '' : 'none';
                }
            }

            searchInput.addEventListener('keyup', filterTable);
            filterStatus.addEventListener('change', filterTable);
            filterTanggal.addEventListener('change', filterTable);
        });

        function resetFilters() {
            document.getElementById('searchPeminjaman').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterTanggal').value = '';
            
            const table = document.getElementById('tablePeminjaman');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            for (let row of rows) {
                row.style.display = '';
            }
        }
    </script>
@endsection