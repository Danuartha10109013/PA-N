<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <div class="w-100"></div>
        {{-- <a class="navbar-brand text-center brand-logo" href="{{ route('dashboard') }}">
            <h6 class=""> System TEKMT Reimbursment</h6>
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            <h4>TEKMT</h4>
        </a> --}}
        @php
            $notif = \App\Models\NotifM::orderBy('created_at');
        @endphp
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button"
            data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

        <ul class="navbar-nav navbar-nav-right">
            @php

                $notif = \App\Models\NotifM::where(function($query) {
                    $query->where('status', 0)  // Unread notifications
                        ->orWhereDate('created_at', \Carbon\Carbon::today());  // Notifications created today
                })->orderBy('created_at', 'desc')->get();

                $unreadCount = \App\Models\NotifM::where('status', 0)->count();
            @endphp
            @if (Auth::user()->role === 'staff keuangan')
                
            <div class="notif-container me-3 position-relative">
                <button id="notifToggle" class="btn btn-light position-relative d-flex align-items-center justify-content-center">
                    <i style="margin-top: 0.5rem;" class="bi bi-bell fs-4"></i>
                    @if($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>
        
                <div id="notifDropdown" class="notif-dropdown shadow p-2" style="display: none;">
                    <div class="fw-bold border-bottom pb-1 mb-2">Notifikasi</div>
                    <ul class="list-unstyled mb-2" style="max-height: 300px; overflow-y: auto;">
                        @forelse($notif as $n)
                        <li class="notif-item px-2 py-2 mb-1 rounded {{ $n->status == 0 ? 'bg-light fw-bold' : 'text-muted' }}" data-id="{{ $n->id }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $n->title }}</strong><br>
                                    <small class="text-muted">{{ $n->value }}</small>
                                    @php
                                        $name = \App\Models\User::where('id',$n->pengirim)->value('name');
                                    @endphp
                                    <br>
                                    <small style="color: blue" class="text-muted">Diajukan oleh {{ $name }}</small>
                                </div>
                                @if($n->status == 0)
                                    <span class="badge bg-danger rounded-pill ms-2">Baru</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill ms-2">Dibaca</span>
                                @endif
                            </div>
                        </li>
                    
                        @empty
                            <li class="text-center text-muted">Tidak ada notifikasi.</li>
                        @endforelse
                    </ul>
        
                    @if($unreadCount > 0)
                        <button id="markAsReadBtn" class="btn btn-sm btn-outline-primary w-100">Tandai Semua Dibaca</button>
                    @endif
                </div>
            </div>
        
            @endif
            <style>
                .notif-container {
                    position: relative;
                }
        
                .notif-dropdown {
                    position: absolute;
                    top: 100%;
                    right: 0;
                    width: 320px;
                    background: #fff;
                    z-index: 999;
                    border-radius: 0.5rem;
                    border: 1px solid #ddd;
                }
        
                .notif-item:hover {
                    background-color: #f8f9fa;
                    cursor: pointer;
                }
        
                /* Adjust the position of the bell icon */
                #notifToggle i {
                    margin-right: 8px; /* Add space between icon and badge */
                }
            </style>
        
        <script>
           document.addEventListener('DOMContentLoaded', function () {
    const notifToggle = document.getElementById('notifToggle');
    const notifDropdown = document.getElementById('notifDropdown');

    // Toggle dropdown
    notifToggle.addEventListener('click', function (e) {
        e.stopPropagation();
        notifDropdown.style.display = notifDropdown.style.display === 'none' ? 'block' : 'none';
    });

    // Hide dropdown on click outside
    document.addEventListener('click', function () {
        notifDropdown.style.display = 'none';
    });

    // Prevent closing when clicking inside dropdown
    notifDropdown.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Mark all as read
    const markBtn = document.getElementById('markAsReadBtn');
    if (markBtn) {
        markBtn.addEventListener('click', function () {
            const notificationIds = @json($notif->pluck('id'));

            fetch('{{ route('notif.markAsRead') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    ids: notificationIds
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update the notification items in the dropdown
                    document.querySelectorAll('.notif-item').forEach(item => {
                        item.classList.remove('bg-light', 'fw-bold');
                        item.classList.add('text-muted');
                        const badge = item.querySelector('.badge');
                        if (badge) {
                            badge.classList.remove('bg-danger');
                            badge.classList.add('bg-secondary');
                            badge.innerText = 'Dibaca';
                        }
                    });
                    // Update the unread count badge
                    document.querySelector('.navbar-toggler .badge')?.classList.add('d-none');
                }
            })
            .catch(err => {
                console.error('Error:', err);
            });
        });
    }
});


        </script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
                   

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown"
                    id="profileDropdown">
                    <i class="typcn typcn-user-outline mr-0"></i>
                    <span class="nav-profile-name">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                        <i class="typcn typcn-cog text-primary"></i>
                        Edit Profile
                    </a>
                    <a class="dropdown-item" onclick="document.getElementById('form-logout').submit()">
                        <i class="typcn typcn-power text-primary"></i>
                        Logout
                    </a>
                    <form action="{{ route('logout') }}" id="form-logout" method="post">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
</nav>
