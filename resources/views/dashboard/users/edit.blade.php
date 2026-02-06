@extends('layouts.dashboard')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --bg-color: #f8fafc;
    }

    .content-wrapper { 
        background-color: var(--bg-color); 
        font-family: 'Plus Jakarta Sans', sans-serif; 
    }

    /* --- Header Styling --- */
    .edit-header {
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
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: #f1f5f9;
        color: #1e293b;
        transform: translateX(-5px);
    }

    /* --- Form Card Styling --- */
    .form-card {
        background: white;
        border-radius: 30px;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 5px;
        background: var(--primary-gradient);
    }

    .form-label {
        font-weight: 700;
        color: #334155;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control, .form-select {
        border-radius: 14px;
        padding: 12px 18px;
        border: 1.5px solid #f1f5f9;
        background-color: #f8fafc;
        transition: all 0.3s;
        color: #1e293b;
        font-weight: 500;
    }

    .form-control:focus, .form-select:focus {
        background-color: white;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    /* --- Action Button --- */
    .btn-save {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 14px 35px;
        font-weight: 700;
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
        transition: all 0.3s;
        width: 100%;
        margin-top: 10px;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(99, 102, 241, 0.3);
        color: white;
    }

    .input-group-text {
        background: transparent;
        border: none;
        padding-left: 0;
        color: #6366f1;
    }

    .password-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 8px;
        display: block;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="edit-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-800 text-dark mb-1">Edit Profil Pengguna</h3>
            <p class="text-muted mb-0">Perbarui informasi akun dan hak akses secara aman.</p>
        </div>
        <a href="{{ route('dashboard.users.index') }}" class="btn-back">
            <i class="bx bx-left-arrow-alt fs-4"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="form-card">
                <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-12">
                            <label for="name" class="form-label">
                                <i class="bx bx-user fs-5 text-primary"></i> Nama Lengkap
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" placeholder="Masukkan nama lengkap"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">
                                <i class="bx bx-envelope fs-5 text-primary"></i> Alamat Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" placeholder="nama@email.com"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="role" class="form-label">
                                <i class="bx bx-shield-quarter fs-5 text-primary"></i> Hak Akses (Role)
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="" disabled>Pilih Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas Lapangan</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <hr class="my-3 opacity-25">
                            <label for="password" class="form-label">
                                <i class="bx bx-lock-alt fs-5 text-primary"></i> Kata Sandi Baru
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="••••••••">
                            <small class="password-hint">
                                <i class="bx bx-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah password.
                            </small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-5">
                            <button type="submit" class="btn-save">
                                <i class="bx bx-check-double me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="info-card p-4 rounded-4" style="background: #eef2ff; border: 1px dashed #6366f1;">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-3">
                    <i class="bx bx-bulb fs-4"></i> Tips Keamanan
                </h6>
                <ul class="text-muted small mb-0 ps-3">
                    <li class="mb-2">Pastikan alamat email aktif untuk keperluan notifikasi sistem.</li>
                    <li class="mb-2">Gunakan kombinasi huruf, angka, dan simbol untuk password yang lebih kuat.</li>
                    <li>Perubahan role akan langsung berdampak pada hak akses pengguna di aplikasi.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection