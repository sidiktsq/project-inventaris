<style>
    /* Warna Dasar Sidebar */
    #layout-menu.bg-dark-premium {
        background: #1e1e2d !important; /* Warna biru gelap charcoal */
        border-right: none;
    }

    /* Styling Link Menu */
    .menu-vertical .menu-link {
        color: #a2a3b7 !important;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-radius: 10px !important;
        margin: 4px 15px !important; /* Memberi ruang antar menu */
        width: calc(100% - 30px) !important;
    }

    /* Efek Menu Aktif (Gradien Modern) */
    .menu-vertical .menu-item.active > .menu-link {
        background: linear-gradient(72deg, #696cff 0%, #8e90ff 100%) !important;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(105, 108, 255, 0.35);
    }

    /* Efek Hover */
    .menu-vertical .menu-link:hover {
        background: rgba(255, 255, 255, 0.05) !important;
        color: #ffffff !important;
        transform: translateX(5px);
    }

    /* Label Header (PAGES) */
    .menu-header {
        margin: 1.5rem 0 0.5rem 0 !important;
        padding: 0 1.5rem !important;
    }
    .menu-header-text {
        color: #565674 !important;
        letter-spacing: 1.2px;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
    }

    /* Brand Logo & Text */
    .app-brand-text {
        font-family: 'Public Sans', sans-serif;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
    .app-brand-logo svg {
        filter: drop-shadow(0 0 8px rgba(105, 108, 255, 0.6));
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-dark-premium shadow-lg">
    <div class="app-brand demo py-4 mb-2">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                    </defs>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-27.000000, -15.000000)">
                            <g transform="translate(27.000000, 15.000000)">
                                <mask id="mask-2" fill="white"><use xlink:href="#path-1"></use></mask>
                                <use fill="#696cff" xlink:href="#path-1"></use>
                            </g>
                        </g>
                    </g>
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-3 text-white">INVAS</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle text-white"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid-alt"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Manajemen Data</span>
        </li>
        
        @if (Auth::user() && Auth::user()->role === 'admin')
        <li class="menu-item {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-voice"></i>
                <div data-i18n="Users">Pengguna</div>
            </a>
        </li>
        @endif
        
        <li class="menu-item {{ request()->is('kategori*', 'lokasi*', 'barang*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Master">Data Master</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <a href="{{ route('kategori.index') }}" class="menu-link">
                        <div data-i18n="Kategori">Kategori</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('lokasi.*') ? 'active' : '' }}">
                    <a href="{{ route('lokasi.index') }}" class="menu-link">
                        <div data-i18n="Lokasi">Lokasi</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                    <a href="{{ route('barang.index') }}" class="menu-link">
                        <div data-i18n="Barang">Stok Barang</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Transaksi</span>
        </li>

        <li class="menu-item {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
            <a href="{{ route('peminjaman.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-git-pull-request"></i>
                <div data-i18n="Peminjaman">Peminjaman</div>
            </a>
        </li>
    </ul>
</aside>