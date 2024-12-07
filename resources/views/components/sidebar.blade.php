<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <div class="d-flex sidebar-profile">
                <div class="sidebar-profile-image">
                    <img src="{{ asset('assets') }}/images/faces/face29.png" alt="image">
                    <span class="sidebar-status-indicator"></span>
                </div>
                <div class="sidebar-profile-name">
                    <p class="sidebar-name">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="sidebar-designation">
                        Active
                    </p>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="typcn typcn-home menu-icon"></i>
                <span class="menu-title">Dashboard </span>
            </a>
        </li>
        {{-- role staff keuangan --}}

        @if (role_staff_keuangan())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('reimbursment.index') }}">
                    <i class="typcn typcn-folder-open  menu-icon"></i>
                    <span class="menu-title">Data Reimbursment </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('laporan.reimbursment') }}">
                    <i class="typcn typcn-document menu-icon"></i>
                    <span class="menu-title">Laporan Reimbursment </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#master-basic" aria-expanded="false"
                    aria-controls="master-basic">
                    <i class="typcn typcn-briefcase menu-icon"></i>
                    <span class="menu-title">Master Data</span>
                    <i class="typcn typcn-chevron-right menu-arrow"></i>
                </a>
                <div class="collapse" id="master-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('jabatan.index') }}">Jabatan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('department.index') }}">Department</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kategori.index') }}">Kategori Reimbursment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pegawai.index') }}">Pegawai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('anggaran.index') }}">Anggaran</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        @if (role_staff_umum())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('reimbursment.pengajuan') }}">
                    <i class="typcn typcn-document-add menu-icon"></i>
                    <span class="menu-title">Pengajuan Reimbursment </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('reimbursment.index') }}">
                    <i class="typcn typcn-time menu-icon"></i>
                    <span class="menu-title">Riwayat Reimbursment </span>
                </a>
            </li>
        @endif

    </ul>
</nav>
