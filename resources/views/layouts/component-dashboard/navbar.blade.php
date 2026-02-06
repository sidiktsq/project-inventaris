<style>
    /* Navbar Container */
    #layout-navbar.bg-navbar-dark {
        background: rgba(30, 30, 45, 0.85) !important; /* Semi-transparent charcoal */
        backdrop-filter: blur(10px); /* Efek kaca (Glassmorphism) */
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        margin-top: 15px;
    }

    /* Search Bar Kustom */
    .search-input-custom {
        background: rgba(255, 255, 255, 0.05) !important;
        border-radius: 8px !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        padding-left: 40px !important;
        transition: all 0.3s ease;
    }

    .search-input-custom:focus {
        background: rgba(255, 255, 255, 0.1) !important;
        border-color: #696cff !important;
        box-shadow: 0 0 10px rgba(105, 108, 255, 0.2) !important;
    }

    /* Icon Warna Putih/Soft */
    .layout-navbar .bx-search, 
    .layout-navbar .bx-menu {
        color: #a2a3b7 !important;
    }

    /* Dropdown User Styling */
    .dropdown-user .dropdown-menu {
        background: #1e1e2d !important;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .dropdown-user .dropdown-item {
        color: #a2a3b7 !important;
        border-radius: 6px;
        margin: 0 8px;
        width: calc(100% - 16px);
    }

    .dropdown-user .dropdown-item:hover {
        background: rgba(105, 108, 255, 0.1) !important;
        color: #fff !important;
    }

    .dropdown-user .dropdown-divider {
        border-color: rgba(255, 255, 255, 0.05);
    }

    /* Avatar Glow */
    .avatar-online img {
        border: 2px solid #696cff;
        box-shadow: 0 0 10px rgba(105, 108, 255, 0.4);
    }
</style>

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-dark" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center position-relative">
                <i class="bx bx-search fs-4 lh-0 position-absolute ms-2"></i>
                <input
                    type="text"
                    class="form-control border-0 shadow-none search-input-custom"
                    placeholder="Cari data inventaris..."
                    aria-label="Search..."
                />
            </div>
        </div>
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item lh-1 me-3">
                <a class="github-button" href="https://github.com/sidiktsq/project-inventaris" data-icon="octicon-star" data-size="large" data-show-count="true">Star</a>
            </li>

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block text-white">{{ Auth::user()->name }}</span>
                                    <small class="text-muted" style="text-transform: capitalize;">{{ Auth::user()->role }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li><div class="dropdown-divider"></div></li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Pengaturan</span>
                        </a>
                    </li>
                    <li><div class="dropdown-divider"></div></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                        <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            </ul>
    </div>
</nav>