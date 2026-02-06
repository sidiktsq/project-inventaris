@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3 header-animate">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mb-2">
                    <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-muted text-decoration-none">Inventaris</a></li>
                    <li class="breadcrumb-item active fw-bold text-primary">Tambah Aset</li>
                </ol>
            </nav>
            <h3 class="fw-extra-bold mb-1 text-dark tracking-tight">Registrasi Barang Baru</h3>
            <p class="text-muted mb-0"><i class="bx bx-info-circle me-1"></i> Pastikan data yang dimasukkan sesuai dengan fisik barang di gudang.</p>
        </div>
        <a href="{{ route('barang.index') }}" class="btn btn-white shadow-sm border-0 rounded-pill px-4 py-2 transition-all hover-lift">
            <i class="bx bx-chevron-left me-1"></i> Kembali ke List
        </a>
    </div>

    @if($errors->any())
        <div id="validationErrors" class="d-none" data-errors='@json($errors->all())'></div>
    @endif

    <form id="formCreateBarang" action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-soft h-100 overflow-hidden">
                    <div class="card-header bg-white border-bottom border-light py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-label-primary rounded-3 me-3">
                                <i class="bx bx-box fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fw-bold">Informasi Utama</h5>
                                <small class="text-muted">Detail spesifikasi produk/aset</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-5">
                                <label class="form-label-custom">Kode Barang</label>
                                <div class="input-group input-group-merge custom-input-group">
                                    <span class="input-group-text bg-soft-light border-0"><i class="bx bx-barcode-reader"></i></span>
                                    <input type="text" name="kode_barang" class="form-control bg-soft-light fw-bold border-0" 
                                        value="{{ $kode_barang }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <label class="form-label-custom">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang" class="form-control form-control-lg custom-input @error('nama_barang') is-invalid @enderror"
                                    value="{{ old('nama_barang') }}" placeholder="Contoh: MacBook Pro M2 2023" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Kategori</label>
                                <select name="kategori_id" class="form-select select2-custom @error('kategori_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Lokasi Penyimpanan</label>
                                <select name="lokasi_id" class="form-select select2-custom @error('lokasi_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Lokasi --</option>
                                    @foreach($lokasis as $l)
                                        <option value="{{ $l->id }}" {{ old('lokasi_id') == $l->id ? 'selected' : '' }}>{{ $l->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label-custom">Deskripsi Spesifikasi</label>
                                <textarea name="deskripsi" class="form-control custom-input" rows="5"
                                    placeholder="Tuliskan detail teknis, serial number, atau catatan khusus di sini...">{{ old('deskripsi') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-soft">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-shape-sm bg-label-warning rounded-2 me-2">
                                        <i class="bx bx-list-check"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0">Status & Kuantitas</h6>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label-custom small">Kondisi Barang</label>
                                    <select name="kondisi" class="form-select custom-input-select border-2">
                                        <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>🟢 Kondisi Baik (Prima)</option>
                                        <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>🟡 Rusak Ringan</option>
                                        <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>🔴 Rusak Berat</option>
                                    </select>
                                </div>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label-custom small">Jumlah</label>
                                        <input type="number" name="jumlah" class="form-control custom-input" value="{{ old('jumlah', 0) }}" min="0">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom small">Satuan</label>
                                        <input type="text" name="satuan" class="form-control custom-input" value="{{ old('satuan') }}" placeholder="Pcs/Unit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-soft bg-gradient-dark">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-4 text-white">Nilai Perolehan</h6>
                                <div class="mb-4">
                                    <label class="form-label text-white-50 small text-uppercase fw-semibold mb-2">Harga Perolehan</label>
                                    <div class="input-group input-group-merge bg-white-10 rounded-3 overflow-hidden">
                                        <span class="input-group-text bg-transparent border-0 text-white fw-bold">Rp</span>
                                        <input type="number" step="0.01" name="harga" class="form-control bg-transparent border-0 text-white placeholder-light" 
                                            value="{{ old('harga') }}" placeholder="0">
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label text-white-50 small text-uppercase fw-semibold mb-2">Tanggal Pembelian</label>
                                    <input type="date" name="tanggal_beli" class="form-control bg-white-10 border-0 text-white date-input-white" value="{{ old('tanggal_beli') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-soft border-dashed-custom">
                            <div class="card-body text-center py-5">
                                <div class="upload-zone">
                                    <div class="avatar avatar-xl bg-label-primary mx-auto mb-3 rounded-circle">
                                        <i class="bx bx-camera fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold">Unggah Foto Aset</h6>
                                    <p class="text-muted small px-3">Ambil gambar yang jelas untuk mempermudah identifikasi barang.</p>
                                    <input type="file" name="foto" class="form-control form-control-sm mt-3 @error('foto') is-invalid @enderror" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 d-flex justify-content-end gap-3 pb-5">
            <button type="reset" class="btn btn-light-danger rounded-pill px-4">
                <i class="bx bx-refresh me-1"></i> Reset
            </button>
            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-primary rounded-pill transition-all hover-scale">
                <i class="bx bx-save me-2"></i> Simpan Registrasi
            </button>
        </div>
    </form>
</div>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Notifikasi Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        // 2. Tampilkan Error Validasi
        const errorContainer = document.getElementById('validationErrors');
        if (errorContainer) {
            const errors = JSON.parse(errorContainer.dataset.errors);
            Swal.fire({
                title: 'Opps! Ada Kesalahan',
                html: `<div class="text-start small"><ul>${errors.map(err => `<li>${err}</li>`).join('')}</ul></div>`,
                icon: 'error',
                confirmButtonColor: '#696cff'
            });
        }

        // 3. Konfirmasi Submit
        const form = document.getElementById('formCreateBarang');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan Data Barang?',
                text: "Pastikan semua data yang dimasukkan sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const btn = form.querySelector('button[type="submit"]');
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';
                    form.submit();
                }
            });
        });

        // 4. Reset Confirmation
        form.addEventListener('reset', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kosongkan Form?',
                text: "Semua data yang telah Anda ketik akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.reset();
                    Toast.fire({
                        icon: 'info',
                        title: 'Form telah dibersihkan'
                    });
                }
            });
        });
    });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

    :root {
        --primary-gradient: linear-gradient(135deg, #696cff 0%, #3f42ef 100%);
        --dark-gradient: linear-gradient(135deg, #434343 0%, #212121 100%);
    }

    body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }

    /* Custom Utility Classes */
    .fw-extra-bold { font-weight: 800; }
    .tracking-tight { letter-spacing: -0.5px; }
    .shadow-soft { box-shadow: 0 10px 30px rgba(0,0,0,0.04) !important; }
    .shadow-primary { box-shadow: 0 8px 20px rgba(105, 108, 255, 0.3) !important; }
    .bg-white-10 { background: rgba(255, 255, 255, 0.15); }
    .bg-soft-light { background-color: #f3f4f6; }
    .placeholder-light::placeholder { color: rgba(255,255,255,0.5); }

    /* Card Styling */
    .card { border-radius: 16px; }
    .bg-gradient-dark { background: var(--dark-gradient); }
    .border-dashed-custom { 
        border: 2px dashed #d1d5db !important; 
        background: #fafafa;
    }

    /* Icon Shapes */
    .icon-shape {
        width: 48px; height: 48px;
        display: flex; align-items: center; justify-content: center;
    }
    .icon-shape-sm {
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
    }

    /* Form Styling */
    .form-label-custom {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 0.6rem;
        display: block;
        letter-spacing: 0.5px;
    }

    .custom-input, .custom-input-select, .select2-custom {
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }

    .custom-input:focus {
        border-color: #696cff;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(105, 108, 255, 0.1);
    }

    /* Date Input Specifics */
    .date-input-white { color-scheme: dark; }

    /* Interaction */
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .hover-scale:hover { transform: scale(1.02); }
    .transition-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

    /* Custom Alert */
    .alert-custom-danger {
        background-color: #fff5f5;
        border-left: 5px solid #ff4d49 !important;
        border-radius: 12px;
    }

    /* Animation */
    .header-animate {
        animation: fadeInDown 0.6s ease-out;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection