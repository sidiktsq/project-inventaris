@extends('layouts.dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-7">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Tambah Pengguna</h3>
                    <p class="text-muted small mb-0">Silakan lengkapi formulir di bawah untuk menambahkan anggota tim baru.</p>
                </div>
                <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-lg p-2" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <form action="{{ route('dashboard.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="name" class="form-label fw-semibold small text-muted">NAMA LENGKAP</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-user text-primary"></i></span>
                                    <input type="text" class="form-control bg-light border-0 @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label for="email" class="form-label fw-semibold small text-muted">ALAMAT EMAIL</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-primary"></i></span>
                                    <input type="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email') }}" placeholder="contoh@domain.com" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label for="role" class="form-label fw-semibold small text-muted">HAK AKSES / ROLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-shield-alt text-primary"></i></span>
                                    <select class="form-select bg-light border-0 @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="" selected disabled>Pilih Role...</option>
                                        <option value="admin">Administrator</option>
                                        <option value="petugas">Petugas Lapangan</option>
                                    </select>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label for="password" class="form-label fw-semibold small text-muted">KATA SANDI</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-primary"></i></span>
                                    <input type="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" 
                                        id="password" name="password" placeholder="Minimal 8 karakter" required>
                                    <button class="btn btn-light border-0" type="button" id="togglePassword">
                                        <i class="far fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary btn-lg shadow rounded-pill fw-bold py-3 transition-all">
                                <i class="fas fa-user-plus me-2"></i> Daftarkan User Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="text-center text-muted small mt-4">
                &copy; {{ date('Y') }} Manajemen Dashboard • Keamanan data terjamin.
            </p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
    
    .card { transition: transform 0.3s ease; }
    
    .form-control, .form-select, .input-group-text {
        padding: 0.75rem 1.25rem;
    }

    .form-control:focus, .form-select:focus {
        background-color: #ffffff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border: 1px solid #0d6efd !important;
    }

    .input-group-text {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    
    .form-control {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .transition-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.3) !important;
    }
    
    /* Menghilangkan border default datatables/bootstrap pada input group */
    .input-group-merge .form-control:focus + .input-group-text {
        border: 1px solid #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script>
    // Fitur Intip Password (Show/Hide)
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>
@endpush