@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Tambah Barang Baru</h4>
            <small class="text-muted">Manajemen Inventaris & Aset</small>
        </div>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bx bx-arrow-back me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <div class="d-flex">
                        <i class="bx bx-error-circle me-2 fs-4"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-12 border-bottom pb-2">
                        <h6 class="text-primary mb-0"><i class="bx bx-info-circle me-1"></i> Informasi Dasar</h6>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kode Barang</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text bg-light"><i class="bx bx-barcode"></i></span>
                            <input type="text" name="kode_barang" class="form-control bg-light" 
                                value="{{ $kode_barang }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                            value="{{ old('nama_barang') }}" placeholder="Masukkan nama lengkap barang" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Lokasi <span class="text-danger">*</span></label>
                        <select name="lokasi_id" class="form-select @error('lokasi_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach($lokasis as $l)
                                <option value="{{ $l->id }}" {{ old('lokasi_id') == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kondisi <span class="text-danger">*</span></label>
                        <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                            <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>🟢 Baik</option>
                            <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>🟡 Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>🔴 Rusak Berat</option>
                            <option value="hilang" {{ old('kondisi') == 'hilang' ? 'selected' : '' }}>⚪ Hilang</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                            value="{{ old('jumlah', 0) }}" min="0" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                        <input type="text" name="satuan" class="form-control @error('satuan') is-invalid @enderror"
                            value="{{ old('satuan') }}" placeholder="Contoh: Unit, Pcs, Box" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Perolehan</label>
                        <input type="date" name="tanggal_beli" class="form-control" value="{{ old('tanggal_beli') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Harga Perolehan (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="0.01" name="harga" class="form-control"
                                value="{{ old('harga') }}" placeholder="0.00">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Deskripsi Tambahan</label>
                        <textarea name="deskripsi" class="form-control" rows="3"
                            placeholder="Detail spesifikasi, nomor seri, atau catatan khusus...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Unggah Foto Barang</label>
                        <div class="border rounded p-3 bg-light">
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            <div class="form-text mt-2"><i class="bx bx-info-circle"></i> Format: JPG, PNG, JPEG. Ukuran Maksimal: 2MB.</div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-2 justify-content-end">
                    <button type="reset" class="btn btn-label-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary px-4 shadow">
                        <i class="bx bx-save me-1"></i> Simpan Data Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection