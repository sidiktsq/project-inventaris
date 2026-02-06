@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Gudang /</span> Edit Barang
            </h4>
            <p class="text-muted small mb-0">Perbarui informasi aset atau inventaris barang Anda.</p>
        </div>
        <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-label-secondary btn-cancel">
            <i class='bx bx-arrow-back me-1'></i> Kembali
        </a>
    </div>

    <!-- Debug Info (can be removed after testing) -->
    @if(empty($kategoris) || empty($lokasis))
        <div class="alert alert-warning">
            @if(empty($kategoris)) <p>Kategori tidak ditemukan</p> @endif
            @if(empty($lokasis)) <p>Lokasi tidak ditemukan</p> @endif
        </div>
    @endif

    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    @if($errors->any())
                        <div id="formErrors" class="d-none" data-errors='@json($errors->all())'></div>
                    @endif
                    @if(session('success'))
                        <div id="successAlert" class="d-none" data-message="{{ session('success') }}"></div>
                    @endif

                    <form id="formEditBarang" action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="divider text-start">
                            <div class="divider-text fw-bold text-primary">
                                <i class='bx bx-info-circle me-1'></i> Informasi Dasar
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kode Barang <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                                    <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror"
                                        value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                                </div>
                                @error('kode_barang') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                                    value="{{ old('nama_barang', $barang->nama_barang) }}" placeholder="Contoh: Laptop MacBook Pro" required>
                                @error('nama_barang') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" id="kategoriSelect" required>
                                    <option value="">Pilih Kategori...</option>
                                    @foreach($kategoris ?? [] as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id', $barang->kategori_id) == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Lokasi Penempatan <span class="text-danger">*</span></label>
                                <select name="lokasi_id" class="form-select @error('lokasi_id') is-invalid @enderror" id="lokasiSelect" required>
                                    <option value="">Pilih Lokasi...</option>
                                    @foreach($lokasis ?? [] as $l)
                                        <option value="{{ $l->id }}" {{ old('lokasi_id', $barang->lokasi_id) == $l->id ? 'selected' : '' }}>
                                            {{ $l->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lokasi_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="divider text-start mt-4">
                            <div class="divider-text fw-bold text-primary">
                                <i class='bx bx-package me-1'></i> Status & Detail
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    <option value="baik" {{ old('kondisi', $barang->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="rusak_ringan" {{ old('kondisi', $barang->kondisi) == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="rusak_berat" {{ old('kondisi', $barang->kondisi) == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Stok / Jumlah <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" 
                                           value="{{ old('jumlah', $barang->jumlah) }}" min="0" required>
                                    <span class="input-group-text">Unit/Pcs</span>
                                </div>
                                @error('jumlah') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Harga Perolehan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                           value="{{ old('harga', $barang->harga) }}">
                                </div>
                                @error('harga') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan / Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                            @error('deskripsi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block">Foto Barang</label>
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ $barang->foto ? asset('storage/' . $barang->foto) : asset('assets/img/elements/1.jpg') }}" 
                                    alt="foto-barang" class="d-block rounded border shadow-sm" height="120" width="120" id="uploadedAvatar" 
                                    style="object-fit: cover"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/elements/1.jpg') }}';">
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-2" tabindex="0">
                                        <span class="d-none d-sm-block">Unggah Foto Baru</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="foto" class="account-file-input @error('foto') is-invalid @enderror" 
                                               hidden accept="image/png, image/jpeg">
                                    </label>
                                    <p class="text-muted mb-0 small">JPG atau PNG. Maksimal 2MB.</p>
                                    @error('foto') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-cancel-confirm">Batal</button>
                            <button type="submit" class="btn btn-primary px-4" id="btnSubmit">
                                <i class='bx bx-save me-1'></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2
        $('#kategoriSelect, #lokasiSelect').select2({
            placeholder: 'Pilih...',
            allowClear: true,
            width: '100%'
        });

        // 1. Toast Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        // 2. Success Alert
        const successData = document.getElementById('successAlert');
        if (successData) {
            const successMessage = successData.getAttribute('data-message');
            Toast.fire({
                title: 'Berhasil!',
                text: successMessage,
                icon: 'success',
                confirmButtonColor: '#696cff',
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            });
        }

        // 3. Error Validation Alert
        const errorData = document.getElementById('formErrors');
        if (errorData) {
            const errors = JSON.parse(errorData.dataset.errors);
            Swal.fire({
                title: 'Opps! Ada Kesalahan',
                html: `<div class="text-start small">${errors.map(err => `<li>${err}</li>`).join('')}</div>`,
                icon: 'error',
                confirmButtonColor: '#696cff'
            });
        }

        // 4. Submit Confirmation
        const form = document.getElementById('formEditBarang');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Simpan',
                text: "Apakah data yang Anda masukkan sudah benar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Cek Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    const btn = document.getElementById('btnSubmit');
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
                    this.submit();
                }
            });
        });

        // 5. Cancel Confirmation
        document.querySelector('.btn-cancel-confirm').addEventListener('click', function() {
            Swal.fire({
                title: 'Batalkan Edit?',
                text: "Perubahan tidak akan disimpan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonText: 'Lanjutkan Edit',
                confirmButtonText: 'Ya, Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('barang.show', $barang->id) }}";
                }
            });
        });

        // 6. Preview Image
        const uploadInput = document.getElementById('upload');
        if (uploadInput) {
            uploadInput.onchange = evt => {
                const [file] = uploadInput.files;
                if (file) {
                    document.getElementById('uploadedAvatar').src = URL.createObjectURL(file);
                }
            }
        }
    });
</script>

<style>
    .divider-text { 
        font-size: 0.85rem; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
    }
    .btn-label-secondary { 
        color: #8592a3; 
        border-color: transparent; 
        background: #ebeef0; 
    }
    .btn-label-secondary:hover { 
        background: #e1e4e6; 
    }
    .form-control:focus, 
    .form-select:focus { 
        border-color: #696cff; 
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.1); 
    }
    /* Select2 Customization */
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 5px 12px;
        border: 1px solid #d9dee3;
        border-radius: 0.375rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
</style>
@endsection