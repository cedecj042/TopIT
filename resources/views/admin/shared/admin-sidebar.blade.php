<div class="col-auto col-md-4 col-xl-2 py-4 px-0 side-bar d-flex flex-column justify-content-between h-100" style="background: linear-gradient(to top, #114A91, #1C81F8);">
    <div class="d-flex flex-column justify-space-between pt-2">
        <h2 class="text-center py-5">
            <img src="{{ asset('assets/logo.svg') }}" alt="TopIT Logo" width="100" height="40">
        </h2>
        <ul class="nav nav-pills d-flex flex-column align-items-center" id="menu">
            <li class="nav-item w-100">
                <a href="{{ route('admin-dashboard') }}" class="nav-link text-white py-3 ps-4 d-flex align-items-center gap-1"
                    id="dashboard-link" data-page="admin-dashboard">
                    <span class="material-symbols-outlined">home</span><span
                        class="ms-1 d-none d-sm-inline fs-6">Dashboard</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a href="{{ route('admin-course') }}" class="nav-link text-white py-3 ps-4 d-flex align-items-center gap-1"
                    id="reviewer-link" data-page="admin-course">
                    <span class="material-symbols-outlined">description</span>
                    <span class="ms-1 d-none d-sm-inline fs-6">Courses</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a href="{{ route('admin-question-bank') }}" class="nav-link text-white py-3 ps-4 d-flex align-items-center gap-1" id="test-link"
                    data-page="admin-question-bank">
                    <span class="material-symbols-outlined">quiz</span> <span
                        class="ms-1 d-none d-sm-inline fs-6">Question Bank</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a href="{{ route('admin-users') }}" class="nav-link text-white py-3 ps-4 d-flex align-items-center gap-1" id="users-link"
                    data-page="users">
                    <span class="material-symbols-outlined">person</span> <span
                        class="ms-1 d-none d-sm-inline fs-6">Manage Users</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="dropdown pb-4 px-4">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                @php
                    if (Auth::user()->userable->profile_image == null) {
                        $profileImageUrl = asset('assets/profile-circle.png');
                    } else {
                        $profileImageUrl = Storage::disk('profile_images')->url(Auth::user()->userable->profile_image);
                    }
                @endphp
                <img src="{{ asset('assets/profile-circle.png') }}" alt="Profile Image" class="rounded-circle" width="30" height="30">
                <span class="d-none d-sm-inline mx-1 fs-6">{{ Auth::user()->username }}</span>
            </a>
        <ul class="dropdown-menu dropdown-menu text-small shadow">
            <li><a class="dropdown-item fs-6" href="{{ route('admin-profile') }}">Profile</a></li>
            <li><a class="dropdown-item fs-6" href="{{ route('logout') }}">Sign out</a></li>
        </ul>
    </div>
</div>
<style>
    .nav-link {
        opacity: 0.7;
        transition: opacity 0.3s ease, background-color 0.3s ease;
    }
    .nav-link.focused {
        background-color: #4D87CD;
        color: white !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('#menu .nav-link');
    const currentPage = '{{ Route::currentRouteName() }}';

    function updateNavLinks(currentRoute) {
        navLinks.forEach(link => {
            const pageName = link.dataset.page;
            if (pageName === currentRoute) {
                link.classList.add('focused');
                link.style.opacity = '1';
                localStorage.setItem('activeNavLink', pageName);
            } else {
                link.classList.remove('focused');
                link.style.opacity = '0.7';
            }
        });
    }

    const storedActiveLink = localStorage.getItem('activeNavLink');
    if (storedActiveLink) {
        updateNavLinks(storedActiveLink);
    } else {
        updateNavLinks(currentPage);
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            updateNavLinks(this.dataset.page);
            window.location.href = this.href;
        });

        link.addEventListener('mouseenter', function() {
            this.style.opacity = '1';
        });
        link.addEventListener('mouseleave', function() {
            if (!this.classList.contains('focused')) {
                this.style.opacity = '0.7';
            }
        });
    });
});
</script>