@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Transaksi /</span> Tambah Peminjaman
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Peminjaman Baru</h5>
            <small class="text-muted float-end">Pastikan stok barang tersedia</small>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('peminjaman.store') }}" method="POST" id="formPeminjaman">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Kode Peminjaman</label>
                        <input type="text" class="form-control" name="kode_peminjaman" 
                               value="{{ $kodeOtomatis ?? '' }}" readonly>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nama Peminjam <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_peminjam') is-invalid @enderror" 
                               name="nama_peminjam" placeholder="Masukkan nama lengkap" 
                               value="{{ old('nama_peminjam') }}" required>
                        @error('nama_peminjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Jenis Peminjam <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_peminjam') is-invalid @enderror" 
                                name="jenis_peminjam" required>
                            <option value="">-- Pilih Jenis Peminjam --</option>
                            <option value="siswa" {{ old('jenis_peminjam') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="guru" {{ old('jenis_peminjam') == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="staf" {{ old('jenis_peminjam') == 'staf' ? 'selected' : '' }}>Staf</option>
                            <option value="luar" {{ old('jenis_peminjam') == 'luar' ? 'selected' : '' }}>Pihak Luar</option>
                        </select>
                        @error('jenis_peminjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Barang yang Dipinjam <span class="text-danger">*</span></label>
                        <select class="form-select @error('barang_id') is-invalid @enderror" 
                                name="barang_id" id="barangSelect" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs ?? [] as $b)
                                <option value="{{ $b->id }}" 
                                        data-stok="{{ $b->jumlah }}"
                                        {{ old('barang_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_barang }} (Tersedia: {{ $b->jumlah }})
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="form-label">Jumlah Pinjam <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                               name="jumlah" id="jumlahPinjam" min="1" 
                               value="{{ old('jumlah', 1) }}" required>
                        <small class="text-muted" id="stokInfo">Stok tersedia: -</small>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="form-label">Kondisi Awal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kondisi_sebelum') is-invalid @enderror" 
                               name="kondisi_sebelum" value="{{ old('kondisi_sebelum', 'Baik') }}" 
                               placeholder="Contoh: Baik/Lengkap" required>
                        @error('kondisi_sebelum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                               name="tanggal_pinjam" id="tanggalPinjam" 
                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                        @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="form-label">Tanggal Estimasi Kembali <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                               name="tanggal_kembali" id="tanggalKembali" 
                               value="{{ old('tanggal_kembali') }}" required>
                        @error('tanggal_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2" id="submitBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
                        <span id="btnText">Simpan Peminjaman</span>
                    </button>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elemen yang diperlukan
        const form = document.getElementById('formPeminjaman');
        const submitBtn = document.getElementById('submitBtn');
        const spinner = document.getElementById('spinner');
        const btnText = document.getElementById('btnText');
        const barangSelect = document.getElementById('barangSelect');
        const jumlahPinjam = document.getElementById('jumlahPinjam');
        const stokInfo = document.getElementById('stokInfo');
        const tanggalPinjam = document.getElementById('tanggalPinjam');
        const tanggalKembali = document.getElementById('tanggalKembali');

        // Set tanggal minimal untuk tanggal kembali
        if (tanggalPinjam && tanggalKembali) {
            // Set tanggal minimal untuk tanggal kembali
            tanggalPinjam.addEventListener('change', function() {
                tanggalKembali.min = this.value;
                if (new Date(tanggalKembali.value) < new Date(this.value)) {
                    tanggalKembali.value = this.value;
                }
            });

            // Inisialisasi tanggal minimal
            const today = new Date().toISOString().split('T')[0];
            tanggalPinjam.min = today;
            if (!tanggalPinjam.value) {
                tanggalPinjam.value = today;
            }
            if (!tanggalKembali.value) {
                const nextWeek = new Date();
                nextWeek.setDate(nextWeek.getDate() + 7);
                tanggalKembali.value = nextWeek.toISOString().split('T')[0];
            }
            tanggalKembali.min = tanggalPinjam.value;
        }

        // Update stok info saat barang dipilih
        if (barangSelect && jumlahPinjam && stokInfo) {
            function updateStokInfo() {
                const selectedOption = barangSelect.options[barangSelect.selectedIndex];
                const stokTersedia = selectedOption ? parseInt(selectedOption.dataset.stok) : 0;
                
                stokInfo.textContent = `Stok tersedia: ${stokTersedia}`;
                jumlahPinjam.max = stokTersedia;
                
                if (parseInt(jumlahPinjam.value) > stokTersedia) {
                    jumlahPinjam.value = stokTersedia;
                }
            }

            barangSelect.addEventListener('change', updateStokInfo);
            window.addEventListener('load', updateStokInfo);
        }

        // Handle form submission
        if (form) {
            form.addEventListener('submit', function(e) {
                // Validasi tambahan
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                } else {
                    // Tampilkan loading
                    submitBtn.disabled = true;
                    spinner.classList.remove('d-none');
                    btnText.textContent = 'Menyimpan...';
                }
                
                form.classList.add('was-validated');
            });
        }
    });
</script>
@endpush

<style>
    /* Gaya untuk form yang tidak valid */
    .was-validated .form-control:invalid,
    .was-validated .form-select:invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    /* Gaya untuk form yang valid */
    .was-validated .form-control:valid,
    .was-validated .form-select:valid {
        border-color: #198754;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    /* Gaya untuk pesan error */
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .was-validated .form-control:invalid ~ .invalid-feedback,
    .was-validated .form-control:invalid ~ .invalid-tooltip,
    .was-validated .form-select:invalid ~ .invalid-feedback,
    .was-validated .form-select:invalid ~ .invalid-tooltip {
        display: block;
    }

    /* Gaya untuk tombol loading */
    .btn .spinner-border {
        margin-right: 0.5rem;
    }
</style>
@endsection