@extends('layouts.dashboard')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container-xxl flex-grow-1 container-p-y" style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fbfbfd;">
    
    <div class="d-md-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-extra-bold mb-1" style="letter-spacing: -1px; color: #1a1c1e;">Overview</h2>
            <p class="text-muted mb-0">Selamat datang kembali, <span class="fw-bold text-primary">{{ Auth::user()->name }}</span>.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <div class="d-flex align-items-center bg-white shadow-sm p-2 px-3" style="border-radius: 12px; border: 1px solid #f0f0f0;">
                <i class='bx bx-calendar-event fs-4 text-primary me-2'></i>
                <div class="text-end">
                    <div class="fw-bold small" style="color: #444;">{{ now()->format('d M Y') }}</div>
                    <div style="font-size: 11px;" class="text-muted text-uppercase fw-bold">{{ now()->format('H:i') }} WIB</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        @php
            $cards = [
                ['label' => 'Total Assets', 'val' => $totalBarang, 'icon' => 'bx-cube-alt', 'color' => '#6366f1'],
                ['label' => 'Active Loans', 'val' => $peminjamanAktif, 'icon' => 'bx-reset', 'color' => '#f59e0b'],
                ['label' => 'Categories', 'val' => $totalKategori, 'icon' => 'bx-grid-alt', 'color' => '#10b981'],
                ['label' => 'Locations', 'val' => $totalLokasi, 'icon' => 'bx-map-alt', 'color' => '#3b82f6'],
            ];
        @endphp
        @foreach($cards as $c)
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card border-0 shadow-soft h-100" style="border-radius: 24px; transition: transform 0.3s ease;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="avatar-box" style="background: {{ $c['color'] }}15; color: {{ $c['color'] }};">
                            <i class='bx {{ $c['icon'] }} fs-3'></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h3 class="fw-extra-bold mb-0" style="color: #1a1c1e;">{{ $c['val'] }}</h3>
                        <span class="text-muted small fw-medium uppercase-tracking">{{ $c['label'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-soft h-100" style="border-radius: 28px;">
                <div class="card-header bg-transparent border-0 p-4 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0" style="color: #1a1c1e;">Peminjaman Terbaru</h5>
                    <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                            <i class='bx bx-dots-horizontal-rounded fs-4'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-faint">
                                <tr>
                                    <th class="ps-4 border-0 text-muted small fw-bold">PEMINJAM</th>
                                    <th class="border-0 text-muted small fw-bold text-center">STATUS</th>
                                    <th class="pe-4 border-0 text-muted small fw-bold text-end">WAKTU</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamanTerbaru as $p)
                                <tr style="cursor: pointer;">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3 fw-bold text-primary bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 12px;">
                                                {{ substr($p->nama_peminjam, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">{{ $p->nama_peminjam }}</div>
                                                <div class="text-muted small">{{ $p->kode_peminjaman }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($p->status == 'dipinjam')
                                            <span class="dot-status bg-warning"></span> <small class="fw-bold text-warning">Active</small>
                                        @else
                                            <span class="dot-status bg-success"></span> <small class="fw-bold text-success">Returned</small>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end text-muted small fw-medium">
                                        {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 text-center py-4">
                    <a href="{{ route('peminjaman.index') }}" class="fw-bold text-primary text-decoration-none small">Lihat Semua Aktivitas <i class='bx bx-right-arrow-alt align-middle'></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 bg-dark shadow-dark mb-4" style="border-radius: 28px;">
                <div class="card-body p-4 text-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 bg-white bg-opacity-10 rounded-3 me-3">
                            <i class='bx bx-shield-quarter fs-3 text-warning'></i>
                        </div>
                        <h6 class="text-white fw-bold mb-0">System Alert</h6>
                    </div>
                    <p class="text-white-50 small mb-4">Ada <span class="text-white fw-bold">{{ $barangStokRendah }} item</span> yang butuh perhatian karena stok kritis.</p>
                    <a href="{{ route('barang.index') }}" class="btn btn-warning w-100 fw-bold py-2 shadow-sm" style="border-radius: 14px;">Review Stok</a>
                </div>
            </div>

            <div class="card border-0 shadow-soft" style="border-radius: 28px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4" style="color: #1a1c1e;">Aksi Cepat</h6>
                    <a href="{{ route('barang.create') }}" class="d-flex align-items-center p-3 mb-3 bg-faint rounded-4 text-decoration-none action-link">
                        <div class="icon-circle bg-primary text-white me-3"><i class='bx bx-plus'></i></div>
                        <div>
                            <div class="fw-bold text-dark small">Tambah Item</div>
                            <div class="text-muted" style="font-size: 11px;">Registrasi aset baru</div>
                        </div>
                    </a>
                    <a href="{{ route('peminjaman.create') }}" class="d-flex align-items-center p-3 bg-faint rounded-4 text-decoration-none action-link">
                        <div class="icon-circle bg-success text-white me-3"><i class='bx bx-transfer'></i></div>
                        <div>
                            <div class="fw-bold text-dark small">Peminjaman</div>
                            <div class="text-muted" style="font-size: 11px;">Input transaksi keluar</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #6366f1;
    }
    .fw-extra-bold { font-weight: 800; }
    .uppercase-tracking { text-transform: uppercase; letter-spacing: 1.5px; font-size: 10px; font-weight: 700; }
    
    .shadow-soft { box-shadow: 0 10px 30px rgba(0,0,0,0.02), 0 5px 10px rgba(0,0,0,0.01) !important; }
    .shadow-dark { box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important; }
    
    .avatar-box {
        width: 54px; height: 54px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 18px;
    }

    .bg-faint { background-color: #f8f9fc; }
    
    .dot-status {
        display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 5px;
    }

    .icon-circle {
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }

    .action-link { transition: all 0.2s ease; border: 1px solid transparent; }
    .action-link:hover { 
        background-color: #fff !important; 
        border-color: #eee;
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* Elegant Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }

    .card:hover { transform: translateY(-5px); }
</style>
@endsection