@extends('layouts.dashboard')

@section('content')
<style>
    :root {
        --glass: rgba(255, 255, 255, 0.9);
        --primary: #696cff;
        --secondary: #8592a3;
    }

    .content-wrapper { background-color: #f5f6fa; font-family: 'Plus Jakarta Sans', sans-serif; }

    /* --- 1. Welcome Banner (Solusi bagian yang kosong) --- */
    .welcome-banner {
        background: linear-gradient(135deg, #696cff 0%, #3f42cc 100%);
        border-radius: 24px;
        padding: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(105, 108, 255, 0.3);
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* --- 2. Info Widgets --- */
    .info-widget {
        background: var(--glass);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }
    .info-widget:hover { transform: translateY(-5px); background: #fff; }
    .widget-icon {
        width: 50px; height: 50px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px;
    }

    /* --- 3. Table Styling (Premium Look) --- */
    .main-card {
        background: white;
        border-radius: 24px;
        border: none;
        box-shadow: 0 4px 25px rgba(0,0,0,0.03);
        padding: 25px;
    }
    .table thead th {
        background: #f9faff;
        color: #8e94a9;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        border: none;
        padding: 15px 20px;
    }
    .table tbody td { padding: 18px 20px; border-bottom: 1px solid #f1f3f9; vertical-align: middle; }
    
    /* --- 4. User Profile --- */
    .user-info-box { display: flex; align-items: center; gap: 12px; }
    .avatar-initials {
        width: 42px; height: 42px;
        background: #e7e7ff; color: #696cff;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1rem;
    }

    /* --- 5. Modern Buttons --- */
    .btn-action-round {
        width: 35px; height: 35px;
        border-radius: 10px;
        display: inline-flex; align-items: center; justify-content: center;
        border: none; transition: 0.2s;
    }
    .btn-edit-lite { background: #eef1ff; color: #696cff; }
    .btn-edit-lite:hover { background: #696cff; color: #fff; }
    .btn-delete-lite { background: #fff0f0; color: #ff3e1d; }
    .btn-delete-lite:hover { background: #ff3e1d; color: #fff; }

</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="welcome-banner h-100 d-flex flex-column justify-content-center">
                <h2 class="fw-bold mb-2">Manajemen User ✨</h2>
                <p class="mb-4 opacity-75">Halo Admin, Anda memiliki kontrol penuh terhadap akses sistem. <br> Kelola pengguna dengan bijak dan efisien.</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-white bg-white text-primary fw-bold px-4 py-2 shadow-sm" style="border-radius: 12px;">
                        <i class="bx bx-plus-circle me-1"></i> Tambah User
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3 h-100">
                <div class="info-widget shadow-sm">
                    <div class="widget-icon bg-light-primary text-primary"><i class="bx bxs-user-account"></i></div>
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">{{ $users->count() }}</h4>
                        <span class="text-muted small">Total Akun Terdaftar</span>
                    </div>
                </div>
                <div class="info-widget shadow-sm">
                    <div class="widget-icon bg-light-success text-success"><i class="bx bxs-check-shield"></i></div>
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">{{ $users->where('role', 'admin')->count() }}</h4>
                        <span class="text-muted small">Administrator Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-card">
        <div class="d-flex justify-content-between align-items-center mb-4 px-2">
            <h5 class="fw-bold m-0"><i class="bx bx-list-ul me-2"></i>Daftar Database Pengguna</h5>
            <div class="badge bg-label-secondary px-3 py-2 rounded-pill text-dark" style="font-size: 0.8rem;">
                <i class="bx bx-sync bx-spin me-1"></i> Terakhir Update: Baru saja
            </div>
        </div>

        <div class="table-responsive">
            <table class="table w-100" id="users-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>User Profile</th>
                        <th>Role Access</th>
                        <th>Registered</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="text-muted fw-bold">{{ $loop->iteration }}</td>
                        <td>
                            <div class="user-info-box">
                                <div class="avatar-initials">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark mb-0">{{ $user->name }}</span>
                                    <span class="text-muted small">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-label-danger rounded-pill px-3">ADMIN</span>
                            @else
                                <span class="badge bg-label-primary rounded-pill px-3">USER</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted small">{{ $user->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn-action-round btn-edit-lite" title="Edit">
                                    <i class="bx bx-pencil"></i>
                                </a>
                                @if(!($loop->first && $user->role === 'admin'))
                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action-round btn-delete-lite" onclick="return confirm('Hapus user?')">
                                        <i class="bx bx-trash"></i>
                                    </button>
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
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
{{-- SweetAlert2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTable
        $('#users-table').DataTable({
            "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>t<"d-flex justify-content-between align-items-center mt-3"ip>',
            "language": {
                "search": "",
                "searchPlaceholder": "Cari user..."
            }
        });
        $('.dataTables_filter input').addClass('form-control shadow-none border-0 bg-light').css('border-radius', '10px');

        // 1. Alert Sukses (Menggantikan baris hijau)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                showClass: { popup: 'animate__animated animate__fadeInDown' }
            });
            // Trik agar notifikasi hijau di layout dashboard tidak muncul
            @php session()->forget('success'); @endphp
        @endif
    });

    // 2. SweetAlert Konfirmasi Hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus User?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush