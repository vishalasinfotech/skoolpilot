<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('dashboard') }}" class="logo logo-dark d-flex align-items-center">
                        <span class="logo-sm">
                            @php
                                $schoolId = auth()->user()->school_id ?? null;
                                $schoolLogo = setting('school_logo', $schoolId);
                            @endphp
                            @if($schoolLogo)
                                <img src="{{ asset($schoolLogo) }}" alt="{{ config('app.name') }}" height="22">
                            @elseif(file_exists(public_path('assets/images/logo-sm.png')))
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="{{ config('app.name') }}" height="22">
                            @else
                                <span class="fw-bold fs-5">{{ config('app.name', 'App Name') }}</span>
                            @endif
                        </span>
                        <span class="logo-lg">
                            @if($schoolLogo)
                                <img src="{{ asset($schoolLogo) }}" alt="{{ config('app.name') }}" height="17">
                            @elseif(file_exists(public_path('assets/images/logo-dark.png')))
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="{{ config('app.name') }}" height="17">
                            @else
                                <span class="fw-bold fs-4">{{ config('app.name', 'App Name') }}</span>
                            @endif
                        </span>
                    </a>

                    <a href="{{ route('dashboard') }}" class="logo logo-light d-flex align-items-center">
                        <span class="logo-sm">
                            @if(file_exists(public_path('assets/images/logo-sm.png')))
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="{{ config('app.name') }}" height="22">
                            @else
                                <span class="fw-bold fs-5">{{ config('app.name', 'App Name') }}</span>
                            @endif
                        </span>
                        <span class="logo-lg">
                            @if(file_exists(public_path('assets/images/logo-light.png')))
                                <img src="{{ asset('assets/images/logo-light.png') }}" alt="{{ config('app.name') }}" height="17">
                            @else
                                <span class="fw-bold fs-4">{{ config('app.name', 'App Name') }}</span>
                            @endif
                        </span>
                    </a>
                </div>

                <button type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="{{ __('common.search_placeholder') }}" autocomplete="off"
                            id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                            id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="index.html" class="btn btn-soft-secondary btn-sm rounded-pill">how to
                                    setup <i class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index.html" class="btn btn-soft-secondary btn-sm rounded-pill">buttons
                                    <i class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                <span>Analytics Dashboard</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span>Help Center</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span>My account settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="assets/images/users/avatar-2.jpg"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-11 mb-0 text-muted">Manager</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="assets/images/users/avatar-3.jpg"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="assets/images/users/avatar-5.jpg"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-11 mb-0 text-muted">React Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results
                                <i class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ __('common.search_placeholder') }}"
                                        aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                @php
                    $userNotifications = \App\Models\NotificationRecipient::where('user_id', auth()->id())
                        ->with(['notification.sender'])
                        ->orderBy('created_at', 'desc')
                        ->limit(20)
                        ->get()
                        ->filter(function($recipient) {
                            return $recipient->notification !== null;
                        });
                    $unreadCount = \App\Models\NotificationRecipient::where('user_id', auth()->id())
                        ->where('is_read', false)
                        ->whereHas('notification')
                        ->count();
                @endphp
                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        @if($unreadCount > 0)
                            <span
                                class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger notification-badge-count">{{ $unreadCount > 99 ? '99+' : $unreadCount }}<span
                                    class="visually-hidden">unread notifications</span></span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">{{ __('common.notifications') }}</h6>
                                    </div>
                                    @if($unreadCount > 0)
                                        <div class="col-auto dropdown-tabs">
                                            <span class="badge bg-light-subtle text-body fs-13 notification-unread-count">{{ $unreadCount }} {{ $unreadCount == 1 ? __('common.new') : __('common.new_plural') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2" id="notifications-list">
                                    @forelse($userNotifications as $notificationRecipient)
                                        @php
                                            $notification = $notificationRecipient->notification;
                                            $sender = $notification->sender ?? null;
                                            $isUnread = !$notificationRecipient->is_read;
                                        @endphp
                                        <a href="{{ route('notification.show', $notificationRecipient->id) }}"
                                           class="text-reset notification-item d-block dropdown-item position-relative {{ $isUnread ? 'bg-light-subtle' : '' }}"
                                           data-notification-id="{{ $notificationRecipient->id }}">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                    @if($sender && $sender->profile_image && file_exists(public_path($sender->profile_image)))
                                                        <img src="{{ asset($sender->profile_image) }}"
                                                             class="rounded-circle avatar-xs"
                                                             alt="{{ $sender->name ?? 'User' }}">
                                                    @else
                                                        <span class="avatar-title bg-{{ $isUnread ? 'primary' : 'secondary' }}-subtle text-{{ $isUnread ? 'primary' : 'secondary' }} rounded-circle fs-16">
                                                            <i class="bx bx-bell"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mt-0 mb-1 fs-13 {{ $isUnread ? 'fw-semibold' : '' }} lh-base">
                                                        {{ $notification->title ?? 'No Title' }}
                                                        @if($isUnread)
                                                            <span class="badge bg-danger ms-1">{{ __('common.new') }}</span>
                                                        @endif
                                                    </h6>
                                                    @if($notification->message)
                                                        <div class="fs-13 text-muted mb-1">
                                                            <p class="mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($notification->message), 80) }}</p>
                                                        </div>
                                                    @endif
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> {{ $notificationRecipient->created_at->diffForHumans() }}</span>
                                                        @if($sender)
                                                            <span class="ms-2">• {{ $sender->name ?? 'System' }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="dropdown-item text-center py-4">
                                            <i class="bx bx-bell-off fs-48 text-muted mb-2 d-block"></i>
                                            <p class="text-muted mb-0">{{ __('common.no_notifications') }}</p>
                                        </div>
                                    @endforelse

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Language Switcher -->
                <div class="dropdown ms-sm-3 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-language-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" title="{{ __('common.select_language') }}">
                        <i class="ri-global-line fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="page-header-language-dropdown">
                        <h6 class="dropdown-header">{{ __('common.language') }}</h6>
                        <form action="{{ route('language.switch') }}" method="POST" id="language-switch-form">
                            @csrf
                            <input type="hidden" name="locale" id="selected-locale" value="{{ app()->getLocale() }}">
                            @php
                                $activeLanguages = \App\Models\Language::active()->orderBy('sort_order')->orderBy('name')->get();
                                $currentLocale = app()->getLocale();
                            @endphp
                            @forelse($activeLanguages as $language)
                                <a class="dropdown-item language-item {{ $currentLocale === $language->code ? 'active' : '' }}"
                                   href="#" data-locale="{{ $language->code }}">
                                    <i class="ri-checkbox-blank-circle-line me-2"></i>
                                    <span>{{ $language->native_name ?? $language->name }}</span>
                                    @if($currentLocale === $language->code)
                                        <i class="ri-check-line float-end"></i>
                                    @endif
                                </a>
                            @empty
                                <a class="dropdown-item language-item active" href="#" data-locale="en">
                                    <i class="ri-checkbox-blank-circle-line me-2"></i>
                                    <span>English</span>
                                    <i class="ri-check-line float-end"></i>
                                </a>
                            @endforelse
                        </form>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('admin_theme/assets/images/default/default.png') }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ Auth::user()->email }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">{{ __('common.welcome') }} {{ Auth::user()->name }}!</h6>
                        <a class="dropdown-item" href="{{ route('profile') }}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">{{ __('common.profile') }}</span></a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">{{ __('common.logout') }}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<script>
    // Language Switcher
    document.addEventListener('DOMContentLoaded', function() {
        const languageItems = document.querySelectorAll('.language-item');
        const languageForm = document.getElementById('language-switch-form');
        const selectedLocale = document.getElementById('selected-locale');

        languageItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const locale = this.getAttribute('data-locale');
                selectedLocale.value = locale;
                languageForm.submit();
            });
        });

        // Notification handling - mark as read when clicked
        const notificationItems = document.querySelectorAll('.notification-item[data-notification-id]');
        notificationItems.forEach(item => {
            item.addEventListener('click', function(e) {
                const notificationId = this.getAttribute('data-notification-id');
                const notificationUrl = this.getAttribute('href');

                // Mark as read via AJAX (non-blocking)
                if (notificationId) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                     document.querySelector('input[name="_token"]')?.value || '';

                    fetch(`/notification/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(response => {
                        if (response.ok) {
                            // Update UI - remove unread styling
                            this.classList.remove('bg-light-subtle');
                            const newBadge = this.querySelector('.badge.bg-danger');
                            if (newBadge) {
                                newBadge.remove();
                            }

                            // Update badge count
                            updateNotificationBadge();
                        }
                    }).catch(error => {
                        console.error('Error marking notification as read:', error);
                    });
                }
            });
        });

        // Function to update notification badge count
        function updateNotificationBadge() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                             document.querySelector('input[name="_token"]')?.value || '';

            fetch('/notifications', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.notification-badge-count');
                const unreadBadge = document.querySelector('.notification-unread-count');

                if (data.unread_count > 0) {
                    if (badge) {
                        badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                        badge.style.display = '';
                    } else {
                        // Create badge if it doesn't exist
                        const button = document.getElementById('page-header-notifications-dropdown');
                        if (button) {
                            const newBadge = document.createElement('span');
                            newBadge.className = 'position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger notification-badge-count';
                            newBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                            newBadge.innerHTML = newBadge.textContent + '<span class="visually-hidden">unread notifications</span>';
                            button.appendChild(newBadge);
                        }
                    }

                    if (unreadBadge) {
                        unreadBadge.textContent = `${data.unread_count} ${data.unread_count == 1 ? 'New' : 'New'}`;
                    }
                } else {
                    if (badge) {
                        badge.remove();
                    }
                    if (unreadBadge) {
                        unreadBadge.remove();
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
            });
        }
    });
</script>
