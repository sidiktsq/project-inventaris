@extends('layouts.dashboard')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --surface-card: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    .content-wrapper { 
        background-color: #f8fafc; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
    }

    /* --- 1. Welcome Banner --- */
    .welcome-banner {
        background: var(--primary-gradient);
        border-radius: 28px;
        padding: 3rem;
        color: white;
        position: relative;
        overflow: hidden;
        border: none;
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -10%; right: -5%;
        width: 300px; height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        filter: blur(50px);
    }

    /* --- 2. Stats Widgets --- */
    .info-widget {
        background: white;
        border-radius: 24px;
        padding: 24px;
        display: flex;
        align-items: center;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .info-widget:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }

    .widget-icon {
        width: 60px; height: 60px;
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 28px;
        margin-right: 18px;
    }

    /* --- 3. Main Card & Table --- */
    .main-card {
        background: white;
        border-radius: 30px;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.02);
        padding: 30px;
        margin-top: 1rem;
    }

    .table { border-collapse: separate; border-spacing: 0 8px; }
    .table thead th {
        background: transparent;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.7rem;
        border: none;
        padding: 15px 25px;
    }

    .table tbody tr td {
        background: #fff;
        border: none;
        padding: 20px 25px;
        vertical-align: middle;
        border-top: 1px solid #f8fafc;
        border-bottom: 1px solid #f8fafc;
    }

    .table tbody tr td:first-child { border-left: 1px solid #f8fafc; border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .table tbody tr td:last-child { border-right: 1px solid #f8fafc; border-top-right-radius: 16px; border-bottom-right-radius: 16px; }

    .table tbody tr:hover td {
        background-color: #fcfcff;
        border-color: #eef2ff;
    }

    /* --- 4. Profile & Badges --- */
    .avatar-initials {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        color: #6366f1;
        border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1.1rem;
    }

    .badge-premium {
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    /* --- 5. Action Buttons --- */
    .btn-action {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: inline-flex; align-items: center; justify-content: center;
        transition: 0.3s;
        border: none;
        cursor: pointer;
    }
    .edit-btn { background: #f0f9ff; color: #0ea5e9; }
    .edit-btn:hover { background: #0ea5e9; color: white; transform: rotate(15deg); }
    .delete-btn { background: #fff1f2; color: #f43f5e; }
    .delete-btn:hover { background: #f43f5e; color: white; transform: rotate(-15deg); }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="welcome-banner h-100 d-flex flex-column justify-content-center">
                <div class="position-relative z-index-1">
                    <h1 class="fw-800 mb-2">User Management System</h1>
                    <p class="mb-4 opacity-75 fs-5">Kendalikan akses dan personalisasi akun pengguna dalam satu dashboard eksklusif.</p>
                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-light fw-bold px-4 py-3 shadow-lg" style="border-radius: 16px;">
                        <i class="bx bx-plus-circle me-2"></i> Buat Akun Baru
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4 h-100">
                <div class="info-widget">
                    <div class="widget-icon" style="background: #eef2ff; color: #6366f1;"><i class="bx bxs-group"></i></div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $users->count() }}</h3>
                        <span class="text-muted fw-medium">Total Pengguna</span>
                    </div>
                </div>
                <div class="info-widget">
                    <div class="widget-icon" style="background: #fff7ed; color: #f59e0b;"><i class="bx bxs-shield-alt"></i></div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $users->where('role', 'admin')->count() }}</h3>
                        <span class="text-muted fw-medium">Admin Terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-card">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
            <div>
                <h4 class="fw-800 m-0 text-dark">Daftar Pengguna</h4>
                <p class="text-muted small mb-0">Kelola informasi dan hak akses user Anda</p>
            </div>
            <div class="text-end">
                 <span class="badge bg-label-secondary p-2 rounded-3 text-dark fw-600">
                    <i class="bx bx-refresh me-1"></i> Data Real-time
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Informasi Pengguna</th>
                        <th>Hak Akses</th>
                        <th>Bergabung</th>
                        <th class="text-end">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="text-muted fw-bold">#{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-initials shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $user->name }}</h6>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge badge-premium bg-label-danger">ADMINISTRATOR</span>
                            @else
                                <span class="badge badge-premium bg-label-primary">REGULAR USER</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-dark fw-medium small">{{ $user->created_at->format('d M Y') }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn-action edit-btn" title="Edit User">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                                
                                {{-- Proteksi agar admin pertama tidak terhapus sendiri --}}
                                @if(!($loop->first && $user->role === 'admin'))
                                <button type="button" class="btn-action delete-btn" onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')" title="Hapus User">
                                    <i class="bx bx-trash"></i>
                                </button>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Fungsi Konfirmasi Hapus
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: "Akun " + userName + " akan dihapus permanen dari sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f43f5e',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'border-radius-20',
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading saat proses hapus
                Swal.fire({
                    title: 'Sedang menghapus...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                document.getElementById('delete-form-' + userId).submit();
            }
        })
    }

    // 2. Notifikasi Toast Sukses Otomatis
    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif

    // 3. Notifikasi Error Otomatis
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            confirmButtonColor: '#6366f1'
        });
    @endif
</script>
@endsection