<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ParkIt')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <div class="logo">ParkIt</div>
        <nav>
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="/find-parking" class="{{ request()->is('find-parking') ? 'active' : '' }}">Find Parking</a>
            <a href="#">Register Parking</a>
            @if(session('user_name'))
                <div class="dropdown" style="display:inline-block;position:relative;">
                    <button class="signin-btn" id="profileDropdownBtn" type="button">
                        {{ session('user_name') }} &#x25BC;
                    </button>
                    <div id="profileDropdown" class="dropdown-content" style="display:none;position:absolute;right:0;background:#fff;min-width:160px;box-shadow:0 2px 8px rgba(0,0,0,0.15);z-index:1;">
                        <a href="/profile" style="display:block;padding:10px 16px;color:#333;text-decoration:none;">View Profile</a>
                        <a href="/profile/edit" style="display:block;padding:10px 16px;color:#333;text-decoration:none;">Update Profile</a>
                        <a href="/logout" style="display:block;padding:10px 16px;color:#e53e3e;text-decoration:none;">Logout</a>
                    </div>
                </div>
                <style>
                    .dropdown-content.show { display: block !important; }
                </style>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var btn = document.getElementById('profileDropdownBtn');
                        var dropdown = document.getElementById('profileDropdown');
                        btn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            dropdown.classList.toggle('show');
                        });
                        document.addEventListener('click', function(e) {
                            if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                                dropdown.classList.remove('show');
                            }
                        });
                    });
                </script>
            @else
                <a href="/signin" class="signin-btn">Sign in</a>
            @endif
        </nav>
    </header>
    @yield('content')
    <footer>
        <div class="footer-content">
            <div class="logo">ParkIt</div>
            <div class="footer-links">
                <a href="#">Contact Us</a>
                <a href="#">Report Issue</a>
                <a href="#">Suggestion</a>
            </div>
            <div class="social-links">
                <a href="#" aria-label="Instagram"><svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1"/></svg></a>
                <a href="#" aria-label="Facebook"><svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 2h-3a4 4 0 00-4 4v3H7v4h4v8h4v-8h3l1-4h-4V6a1 1 0 011-1h3z"/></svg></a>
                <a href="#" aria-label="Twitter"><svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0022.4.36a9.09 9.09 0 01-2.88 1.1A4.48 4.48 0 0016.11 0c-2.5 0-4.5 2.01-4.5 4.5 0 .35.04.7.11 1.03C7.69 5.4 4.07 3.7 1.64 1.15c-.38.65-.6 1.4-.6 2.2 0 1.52.77 2.86 1.94 3.65A4.48 4.48 0 003 7.5v.05A12.94 12.94 0 011.67 1.15c0 1.52.77 2.86 1.94 3.65A4.48 4.48 0 003 7.5v.05A12.94 12.94 0 0012 21c7.18 0 11.13-5.95 11.13-11.13 0-.17 0-.34-.01-.51A7.72 7.72 0 0023 3z"/></svg></a>
            </div>
        </div>
        <div class="footer-copyright">
            © 2024 Your Website. All rights reserved. &nbsp; <a href="#">Privacy Policy</a> &nbsp; <a href="#">Terms of Service</a>
        </div>
    </footer>
</body>
</html>
