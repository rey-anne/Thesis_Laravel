<header class="vf-navbar">
    <div class="vf-stripe"></div>
    <div class="vf-navbar__inner">
        <a href="{{ route('home') }}" class="vf-navbar__brand">
            <img src="{{ asset('images/logo.png') }}" alt="VeriFyre logo">
            <span>VeriFyre</span>
        </a>

        <nav class="vf-navbar__links" id="vfNavLinks">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('report.create') }}">Report</a>
            <a href="{{ route('crowdsource') }}">Crowdsource</a>
            <a href="{{ route('education') }}">Education</a>
            <a href="{{ route('cybersecurity') }}">Cybersecurity</a>
            <a href="{{ route('about') }}">About Us</a>

            @auth
                {{-- Logged-in staff: show role-specific dashboard link + logout --}}
                @php($role = auth()->user()->role ?? null)
                @if($role === 'bfp_firefighter')
                    <a href="{{ route('firefighter.home') }}">Dashboard</a>
                @elseif(in_array($role, ['admin','superadmin']))
                    <a href="{{ route('admin.home') }}">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="vf-navbar__logout-form">
                    @csrf
                    <button type="submit" class="vf-link-btn">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="vf-navbar__login">Log In</a>
            @endauth
        </nav>

        <button class="vf-navbar__toggle" id="vfNavToggle" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<script>
    // Collapsible side-drawer nav on mobile
    document.getElementById('vfNavToggle').addEventListener('click', function () {
        document.getElementById('vfNavLinks').classList.toggle('vf-navbar__links--open');
        this.classList.toggle('vf-navbar__toggle--active');
    });
</script>
