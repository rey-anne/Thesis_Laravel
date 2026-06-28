<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'VeriFyre')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">

    <style>
        :root {
            --vf-bg: #F9F6EE;
            --vf-surface: #FFFFFF;
            --vf-ink: #1F2123;
            --vf-muted: #6B6F76;
            --vf-red: #E53935;
            --vf-red-deep: #B71C1C;
            --vf-hero-accent: #FF2C20;
            --vf-red-tint: #FBE9E7;
            --vf-line: rgba(31, 33, 35, 0.10);
            --vf-shadow: 0 12px 32px rgba(31,33,35,0.10);
            --vf-shadow-sm: 0 4px 14px rgba(31,33,35,0.08);
            --vf-radius: 16px;
            --vf-radius-sm: 10px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: var(--vf-font-body, 'Source Sans 3', Arial, sans-serif);
            background: var(--vf-bg);
            color: var(--vf-ink);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--vf-font-display, 'Barlow Condensed', Arial, sans-serif);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .vf-stripe {
            height: 4px;
            width: 100%;
            background: var(--vf-red);
        }

        .vf-navbar {
            background: var(--vf-bg);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--vf-shadow-sm);
        }

        .vf-navbar__inner {
            max-width: 1240px;
            margin: 0 auto;
            min-height: 74px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 28px;
        }

        .vf-navbar__brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 30px;
            font-weight: 900;
            color: var(--vf-red);
            letter-spacing: -0.8px;
            line-height: 1;
        }

        .vf-navbar__brand img {
            width: 40px !important;
            height: 40px !important;
            max-width: 40px !important;
            max-height: 40px !important;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            border: 2px solid var(--vf-red-tint);
        }

        .vf-navbar__links {
            display: flex;
            align-items: center;
            gap: 30px;
            font-weight: 700;
            font-size: 15px;
            color: var(--vf-ink);
        }

        .vf-navbar__links a {
            position: relative;
            padding: 8px 0;
            line-height: 1;
            white-space: nowrap;
            transition: color 0.2s ease;
        }

        .vf-navbar__links a:not(.vf-navbar__login)::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -7px;
            width: 0;
            height: 3px;
            background: var(--vf-red);
            border-radius: 999px;
            transition: width 0.2s ease;
        }

        .vf-navbar__links a:not(.vf-navbar__login):hover {
            color: var(--vf-red);
        }

        .vf-navbar__links a:not(.vf-navbar__login):hover::after {
            width: 100%;
        }

        .vf-navbar__login {
            background: var(--vf-red) !important;
            color: #ffffff !important;
            padding: 0 24px !important;
            min-width: 92px;
            height: 42px;
            border-radius: 999px !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            font-weight: 800 !important;
            white-space: nowrap;
            box-shadow:
                0 6px 14px rgba(229, 57, 53, 0.35),
                0 0 12px rgba(229, 57, 53, 0.25);
            transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
        }

        .vf-navbar__login:hover {
            background: var(--vf-red-deep) !important;
            transform: translateY(-1px);
            box-shadow:
                0 10px 22px rgba(229, 57, 53, 0.42),
                0 0 18px rgba(229, 57, 53, 0.45);
        }

        .vf-navbar__toggle {
            display: none;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            width: 34px;
            height: 34px;
            background: none;
            border: none;
            cursor: pointer;
        }

        .vf-navbar__toggle span {
            width: 100%;
            height: 3px;
            background: var(--vf-red);
            border-radius: 2px;
        }

        .vf-section {
            max-width: 1240px;
            margin: 0 auto;
            padding: 64px 28px;
        }

        .vf-card {
            background: var(--vf-surface);
            border-radius: var(--vf-radius);
            box-shadow: var(--vf-shadow);
            border: 1px solid var(--vf-line);
            padding: 32px;
        }

        .vf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--vf-red);
            color: #fff;
            padding: 15px 32px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
        }

        .vf-btn:hover {
            background: var(--vf-red-deep);
            transform: translateY(-1px);
        }

        .vf-hero {
            position: relative;
            min-height: 560px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            background-size: cover;
            background-position: center;
        }

        .vf-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(20, 12, 12, 0.72),
                rgba(20, 12, 12, 0.45) 55%,
                rgba(20, 12, 12, 0.78)
            );
        }

        .vf-hero__content {
            position: relative;
            z-index: 1;
            max-width: 820px;
            padding: 0 28px;
            margin: 0 auto;
        }

        .vf-hero h1 {
            font-family: var(--vf-font-display, 'Barlow Condensed', Arial, sans-serif);
            font-size: 64px;
            font-weight: 900;
            line-height: 1.05;
            margin: 0 0 18px;
            letter-spacing: -1.5px;
            color: var(--vf-hero-accent);
            text-shadow: 0 2px 16px rgba(0, 0, 0, 0.55);
        }

        .vf-hero p {
            font-size: 18px;
            font-weight: 600;
            max-width: 650px;
            margin: 0 auto 28px;
            color: #fff;
        }

        .vf-map {
            width: 100%;
            height: 420px;
            border-radius: var(--vf-radius);
            overflow: hidden;
            box-shadow: var(--vf-shadow);
            border: 1px solid var(--vf-line);
        }

        .vf-camera-box {
            width: 100%;
            max-width: 480px;
            aspect-ratio: 4 / 3;
            background: var(--vf-ink);
            border-radius: var(--vf-radius);
            overflow: hidden;
            position: relative;
            margin: 0 auto 24px;
            border: 3px solid var(--vf-red);
        }

        .vf-camera-box video,
        .vf-camera-box canvas,
        .vf-camera-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vf-footer {
            display: block;
            width: 100%;
            margin-top: 64px;
        }

        .vf-footer__bar {
            background: var(--vf-ink);
            color: #fff;
            width: 100%;
        }

        .vf-footer__inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 36px 28px;
            display: flex;
            flex-wrap: wrap;
            gap: 28px;
            justify-content: space-between;
        }

        .vf-footer__brand strong {
            font-size: 22px;
            color: var(--vf-red);
        }

        .vf-footer p {
            margin: 3px 0;
            font-size: 14px;
            opacity: 0.78;
        }

        .vf-footer__contact strong,
        .vf-footer__rights strong {
            color: #fff;
        }

        @media (max-width: 1024px) {
            .vf-navbar__toggle {
                display: flex;
            }

            .vf-navbar__links {
                position: fixed;
                top: 0;
                right: -280px;
                height: 100vh;
                width: 260px;
                max-width: 80vw;
                background: var(--vf-surface);
                flex-direction: column;
                align-items: flex-start;
                padding: 90px 24px 24px;
                box-shadow: -6px 0 24px rgba(0, 0, 0, 0.14);
                transition: right 0.25s ease;
                gap: 24px;
                overflow-y: auto;
                z-index: 1001;
            }

            .vf-navbar__links--open {
                right: 0;
            }
        }

        /* Hide crowdsourcing popup by default */
.vf-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(20, 12, 12, 0.6);
    backdrop-filter: blur(8px);
    display: none !important;
    align-items: center;
    justify-content: center;
    padding: 16px;
    z-index: 2000;
}

/* Show only when nearby fire is detected */
.vf-modal-overlay--active {
    display: flex !important;
}

.vf-crowdsource-modal {
    background: var(--vf-surface);
    border-radius: 24px;
    padding: 36px;
    max-width: 380px;
    text-align: center;
    box-shadow: var(--vf-shadow);
    border-top: 5px solid var(--vf-red);
}

.vf-verify-btn {
    width: 132px;
    height: 132px;
    border-radius: 50%;
    background: var(--vf-red);
    color: #fff;
    font-weight: 900;
    font-size: 22px;
    border: none;
    margin: 22px auto;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
/* AUTH / LOGIN PAGE */
.vf-auth-wrap {
    min-height: calc(100vh - 260px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 64px 18px;
}

.vf-auth-card {
    background: var(--vf-surface);
    width: 100%;
    max-width: 460px;
    padding: 44px 40px;
    border-radius: 22px;
    box-shadow: var(--vf-shadow);
    border: 1px solid var(--vf-line);
    border-top: 5px solid var(--vf-red);
}

.vf-auth-card h1 {
    text-align: center;
    margin: 0 0 6px;
    font-size: 36px;
    font-weight: 900;
    color: var(--vf-ink);
}

.vf-label {
    display: block;
    margin-bottom: 7px;
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--vf-muted);
}

.vf-input {
    width: 100%;
    height: 48px;
    padding: 12px 15px;
    margin-bottom: 18px;
    border: 1.5px solid var(--vf-line);
    border-radius: var(--vf-radius-sm);
    background: #fff;
    color: var(--vf-ink);
    font-size: 15px;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.vf-input:focus {
    outline: none;
    border-color: var(--vf-red);
    box-shadow: 0 0 0 4px rgba(229, 57, 53, 0.12);
}

.vf-auth-submit {
    width: 100%;
    height: 50px;
    margin-top: 4px;
}

.vf-auth-links {
    margin-top: 20px;
    background: var(--vf-red-tint);
    border-left: 4px solid var(--vf-red);
    border-radius: var(--vf-radius-sm);
    padding: 13px 16px;
    display: flex;
    justify-content: space-between;
    gap: 12px;
    font-weight: 800;
    font-size: 14px;
}

.vf-auth-links a {
    color: var(--vf-red-deep);
}

.vf-auth-links a:hover {
    text-decoration: underline;
}

.vf-error {
    color: var(--vf-red-deep);
    background: var(--vf-red-tint);
    border-radius: var(--vf-radius-sm);
    padding: 10px 14px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 16px;
}

@media (max-width: 480px) {
    .vf-auth-card {
        padding: 34px 22px;
    }
}
    </style>

    @yield('styles')
    @stack('styles')
</head>
<body>

<div class="vf-stripe"></div>

<header class="vf-navbar">
    <div class="vf-navbar__inner">

        <a href="{{ route('home') }}" class="vf-navbar__brand">
            <img src="{{ asset('images/logo.png') }}" alt="VeriFyre Logo">
            <span>VeriFyre</span>
        </a>

        <button class="vf-navbar__toggle" type="button" id="vfNavToggle" aria-label="Open navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="vf-navbar__links" id="vfNavLinks">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('report.create') }}">Report</a>
            <a href="{{ route('education') }}">Education</a>
            <a href="{{ route('cybersecurity') }}">Cybersecurity</a>
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('login') }}" class="vf-navbar__login">Log In</a>
        </nav>

    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="vf-footer">
    <div class="vf-footer__bar">
        <div class="vf-footer__inner">

            <div class="vf-footer__brand">
                <strong>VeriFyre</strong>
                <p>Innovision, FEU Institute of Technology</p>
            </div>

            <div class="vf-footer__contact">
                <strong>Contact the Team</strong>
                <p>+63 947 869 1441</p>
                <p>innovision.verifrye@gmail.com</p>
            </div>

            <div class="vf-footer__rights">
                <p>© 2026 VeriFyre. All Rights Reserved.</p>
            </div>

        </div>
    </div>
</footer>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("vfNavToggle");
    const links = document.getElementById("vfNavLinks");

    if (toggle && links) {
        toggle.addEventListener("click", function () {
            links.classList.toggle("vf-navbar__links--open");
        });
    }
});
</script>

@yield('scripts')
@stack('scripts')

</body>
</html>