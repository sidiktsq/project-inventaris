@extends('layouts.dashboard')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f0f2f9; }

    /* Header Styling */
    .premium-header {
        background: linear-gradient(135deg, #00b894 0%, #006266 100%);
        padding: 3rem 2rem 3rem 2rem;
        border-radius: 30px;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 15px 35px rgba(0, 184, 148, 0.25);
        position: relative;
        z-index: 1;
    }

    /* Form Card Styling */
    .content-overlay {
        position: relative;
        z-index: 2;
        padding: 0 1.5rem;
    }

    .main-card {
        background: #ffffff;
        border-radius: 25px;
        border: none;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }

    .card-header-premium {
        background: #f8faff;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f0f2f9;
    }

    /* Input Styling */
    .form-label {
        font-weight: 600;
        color: #566a7f;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-group-merge {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1.5px solid #d9dee3;
    }

    .input-group-merge:focus-within {
        border-color: #00b894;
        box-shadow: 0 0 0 0.25rem rgba(0, 184, 148, 0.1);
    }

    .input-group-text {
        background-color: transparent;
        border: none;
        color: #00b894;
        padding-left: 1.2rem;
    }

    .form-control {
        border: none !important;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }

    .form-control:focus {
        box-shadow: none;
    }

    /* Button Styling */
    .btn-save {
        background: #00b894;
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-save:hover {
        background: #00a383;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 184, 148, 0.3);
        color: white;
    }

    .btn-cancel {
        background: #ebeef0;
        color: #8592a3;
        padding: 0.8rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background: #e1e4e6;
        color: #697a8d;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="premium-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3" style="background: rgba(255,255,255,0.2); padding: 12px; border-radius: 15px;">
                <i class="bx bx-edit text-white fs-2"></i>
            </div>
            <div>
                <h2 class="fw-bold text-white mb-0">Edit Informasi Lokasi</h2>
                <p class="text-white-50 mb-0">Update klasifikasi penyimpanan #ID-{{ $lokasi->id }}</p>
            </div>
        </div>
    </div>

    <div class="content-overlay">
        <div class="card main-card">
            <div class="card-header-premium d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bx bx-edit-alt me-2 text-success"></i>Ubah Detail Lokasi</h5>
                <span class="badge bg-label-warning rounded-pill">Mode Edit</span>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('lokasi.update', $lokasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="nama">Nama Lokasi</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                <input type="text" name="nama" id="nama" 
                                    class="form-control @error('nama') is-invalid @enderror" 
                                    placeholder="Contoh: Gudang B, Lab Komputer" 
                                    value="{{ old('nama', $lokasi->nama) }}" required />
                            </div>
                            @error('nama')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label" for="deskripsi">Deskripsi Lokasi</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-detail"></i></span>
                                <textarea name="deskripsi" id="deskripsi" rows="4"
                                    class="form-control @error('deskripsi') is-invalid @enderror" 
                                    placeholder="Update detail atau keterangan lokasi...">{{ old('deskripsi', $lokasi->deskripsi) }}</textarea>
                            </div>
                            @error('deskripsi')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="{{ route('lokasi.index') }}" class="btn btn-cancel">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-save">
                            <i class="bx bx-check me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection