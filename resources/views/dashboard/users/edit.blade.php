@extends('layouts.dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}" class="text-decoration-none">Users</a></li>
                    <li class="breadcrumb-item active fw-bold" aria-current="page">Edit Profil</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-soft-primary text-primary me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">Edit Data Pengguna</h5>
                    </div>
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-light btn-sm rounded-pill px-3 border">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="far fa-user"></i></span>
                                    <input type="text" class="form-control border-start-0 bg-light @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama..." required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label small fw-bold text-uppercase text-muted">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="far fa-envelope"></i></span>
                                    <input type="email" class="form-control border-start-0 bg-light @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="email@domain.com" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="role" class="form-label small fw-bold text-uppercase text-muted">Hak Akses / Role</label>
                                <select class="form-select bg-light @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="" disabled>Pilih Role...</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                                    <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                </select>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-3 opacity-25">

                            <div class="col-md-12 mb-4">
                                <label for="password" class="form-label small fw-bold text-uppercase text-muted">Ganti Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control border-start-0 bg-light @error('password') is-invalid @enderror" 
                                        id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                </div>
                                <div class="form-text text-muted small">
                                    <i class="fas fa-info-circle me-1"></i> Kosongkan jika tidak ingin mengubah password.
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">
                            <button type="reset" class="btn btn-light px-4 rounded-pill">Reset</button>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    body { background-color: #f8fafc; }
    
    .bg-soft-primary {
        background-color: #e0e7ff;
    }
    
    .card {
        border-radius: 16px;
    }
    
    .form-control, .form-select, .input-group-text {
        border-radius: 8px;
        padding: 0.6rem 1rem;
        border: 1px solid #e2e8f0;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    
    .input-group-text {
        color: #94a3b8;
    }
    
    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-size: 1.2rem;
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    // Form validation and submission
    document.querySelector('form').addEventListener('submit', function(e) {
        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.text-danger').forEach(el => el.remove());
        
        // Validate required fields
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const role = document.getElementById('role');
        
        let isValid = true;
        
        if (!name.value.trim()) {
            name.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-danger small mt-1';
            errorDiv.textContent = 'Nama harus diisi';
            name.parentElement.parentElement.appendChild(errorDiv);
            isValid = false;
        }
        
        if (!email.value.trim()) {
            email.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-danger small mt-1';
            errorDiv.textContent = 'Email harus diisi';
            email.parentElement.parentElement.appendChild(errorDiv);
            isValid = false;
        }
        
        if (!role.value) {
            role.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-danger small mt-1';
            errorDiv.textContent = 'Role harus dipilih';
            role.parentElement.appendChild(errorDiv);
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
@endpush