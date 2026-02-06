@extends('layouts.dashboard')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
    }

    .content-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }

    /* Header Styling */
    .page-header {
        margin-bottom: 2rem;
    }

    .btn-back {
        background: white;
        color: #64748b;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: #f1f5f9;
        color: #1e293b;
        transform: translateX(-5px);
    }

    /* Card Styling */
    .custom-card {
        background: white;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .card-accent {
        height: 6px;
        background: var(--primary-gradient);
    }

    .card-body-content {
        padding: 40px;
    }

    /* Form Elements */
    .form-label {
        font-weight: 700;
        color: #334155;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1.5px solid #e2e8f0;
        background-color: #fcfdfe;
        transition: all 0.2s;
        font-weight: 500;
    }

    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
        background-color: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    /* Button Save */
    .btn-save {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 700;
        width: 100%;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
        transition: all 0.3s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(99, 102, 241, 0.35);
        opacity: 0.95;
    }

    /* Icon Decoration */
    .input-icon {
        color: #6366f1;
        font-size: 1.1rem;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y mt-3">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-800 text-dark mb-1">Tambah Pengguna Baru</h3>
            <p class="text-muted mb-0 small">Daftarkan akun petugas atau admin baru ke dalam sistem.</p>
        </div>
        <a href="{{ route('dashboard.users.index') }}" class="btn-back">
            <i class="bx bx-arrow-back"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="custom-card">
                <div class="card-accent"></div>
                <div class="card-body-content">
                    <form action="{{ route('dashboard.users.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    <i class="bx bx-user input-icon"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" placeholder="Contoh: John Doe" 
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="bx bx-envelope input-icon"></i> Alamat Email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" placeholder="john@example.com"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label">
                                    <i class="bx bx-shield-alt-2 input-icon"></i> Hak Akses (Role)
                                </label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="" selected disabled>Pilih Role...</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    <i class="bx bx-lock-alt input-icon"></i> Kata Sandi
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" placeholder="Minimal 8 karakter" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-5">
                                <div class="p-3 rounded-3 mb-4" style="background-color: #f0f4ff; border-left: 4px solid #6366f1;">
                                    <p class="small text-muted mb-0">
                                        Pastikan data yang dimasukkan sudah benar. Password akan langsung dienkripsi oleh sistem demi keamanan pengguna.
                                    </p>
                                </div>
                                <button type="submit" class="btn-save">
                                    <i class="bx bx-plus-circle fs-5"></i> Simpan Data Pengguna
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection