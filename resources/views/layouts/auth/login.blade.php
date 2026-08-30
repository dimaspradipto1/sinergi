<!DOCTYPE html>
<html lang="id" data-theme="default">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Portal Masuk - SINERGI PLD | Pusat Layanan Disabilitas UIS</title>
    <meta content="Sistem Informasi Layanan Disabilitas (SINERGI) - Portal Resmi Pusat Layanan Disabilitas Universitas" name="description">
    <meta content="pld, disabilitas, inklusi, kampus ramah disabilitas, sinergi, uis" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logouis.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logouis.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        :root {
            --brand-navy: #091e42;
            --brand-primary: #155eef;
            --brand-primary-hover: #124ec4;
            --brand-primary-light: #eff4ff;
            --brand-teal: #088395;
            --brand-teal-light: #e0f4f7;
            --brand-accent: #0284c7;
            --brand-surface: #f8fafc;
            --brand-border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --font-base: 'Plus Jakarta Sans', sans-serif;
            --font-display: 'Lexend', 'Plus Jakarta Sans', sans-serif;
            --base-font-size: 15px;
        }

        /* High Contrast Theme */
        body.theme-high-contrast {
            --brand-navy: #000000;
            --brand-primary: #002244;
            --brand-primary-hover: #000000;
            --brand-primary-light: #ffffff;
            --brand-surface: #ffffff;
            --brand-border: #000000;
            --text-main: #000000;
            --text-muted: #111111;
            background: #ffffff !important;
            color: #000000 !important;
        }
        body.theme-high-contrast * {
            border-color: #000000 !important;
        }
        body.theme-high-contrast .service-pill-item,
        body.theme-high-contrast .form-control-pro {
            border: 2px solid #000000 !important;
            background: #ffffff !important;
            color: #000000 !important;
            box-shadow: none !important;
        }
        body.theme-high-contrast .btn-brand-primary {
            background: #000000 !important;
            color: #ffffff !important;
            border: 2px solid #000000 !important;
        }

        /* Dyslexic font mode */
        body.font-dyslexic {
            font-family: 'Comic Sans MS', 'Trebuchet MS', sans-serif !important;
            letter-spacing: 0.04em !important;
            word-spacing: 0.08em !important;
        }

        html {
            font-size: var(--base-font-size);
            height: 100%;
        }

        body {
            font-family: var(--font-base);
            background-color: #f1f5f9;
            color: var(--text-main);
            margin: 0;
            padding: 0;
            height: 100vh;
            max-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Top Institutional Bar */
        .inst-header {
            background: #ffffff;
            border-bottom: 1px solid var(--brand-border);
            padding: 0.5rem 2rem;
            flex-shrink: 0;
            z-index: 100;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }
        .inst-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .inst-logo {
            height: 38px;
            width: auto;
            object-fit: contain;
        }
        .inst-text-title {
            font-family: var(--font-display);
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--brand-navy);
            line-height: 1.1;
            letter-spacing: -0.02em;
        }
        .inst-text-subtitle {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--brand-teal);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        /* Accessibility Quick Control Bar */
        .a11y-control-group {
            display: flex;
            align-items: center;
            gap: 4px;
            background: #f8fafc;
            border: 1px solid var(--brand-border);
            padding: 3px 6px;
            border-radius: 50px;
        }
        .a11y-btn-item {
            background: transparent;
            border: 1px solid transparent;
            color: #475569;
            font-size: 0.74rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }
        .a11y-btn-item:hover, .a11y-btn-item:focus {
            background: #ffffff;
            border-color: #cbd5e1;
            color: var(--brand-primary);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            outline: 2px solid var(--brand-primary);
        }
        .a11y-btn-item.active {
            background: var(--brand-primary);
            color: #ffffff;
        }

        /* Main Workspace: 2-Column Institutional Split */
        .main-portal-wrapper {
            flex: 1;
            display: flex;
            min-height: 0;
            overflow: hidden;
        }

        /* Left Showcase Column */
        .portal-showcase-panel {
            flex: 1.25;
            background: linear-gradient(145deg, #071739 0%, #0b285a 40%, #0a4d68 85%, #088395 100%);
            color: #ffffff;
            padding: 2rem 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .portal-showcase-panel::after {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .showcase-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.76rem;
            font-weight: 600;
            color: #e0f2fe;
            margin-bottom: 0.85rem;
        }
        .showcase-badge-pill .pulse-dot {
            width: 7px;
            height: 7px;
            background: #4ade80;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(74, 222, 128, 0.3);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        .showcase-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.65rem;
            font-weight: 700;
            line-height: 1.35;
            letter-spacing: -0.01em;
            color: #ffffff;
            margin-bottom: 0.85rem;
        }
        .showcase-title span.highlight-teal {
            color: #38bdf8;
            background: none;
            -webkit-text-fill-color: initial;
            font-weight: 700;
        }

        .showcase-desc {
            font-size: 0.88rem;
            line-height: 1.5;
            color: #cbd5e1;
            max-width: 580px;
            margin-bottom: 1.25rem;
        }

        /* 4 Pillars Grid */
        .services-showcase-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            max-width: 640px;
            margin-bottom: 1rem;
        }
        .service-pill-item {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 10px 12px;
            border-radius: 12px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            transition: all 0.2s ease;
        }
        .service-pill-item:hover {
            background: rgba(255, 255, 255, 0.14);
            transform: translateY(-1px);
            border-color: rgba(56, 189, 248, 0.4);
        }
        .service-icon-box {
            width: 32px;
            height: 32px;
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #38bdf8;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .service-info h4 {
            font-size: 0.84rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 2px 0;
        }
        .service-info p {
            font-size: 0.72rem;
            color: #94a3b8;
            margin: 0;
            line-height: 1.35;
        }

        /* Showcase Stats Bar */
        .showcase-stats-bar {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding-top: 0.85rem;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }
        .stat-item-col h3 {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 800;
            color: #38bdf8;
            margin: 0;
        }
        .stat-item-col p {
            font-size: 0.72rem;
            color: #cbd5e1;
            margin: 0;
            font-weight: 500;
        }

        /* Right Authentication Panel */
        .portal-form-panel {
            flex: 0.95;
            background: #ffffff;
            padding: 2rem 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow-y: auto;
        }

        .auth-header-block {
            margin-bottom: 1.5rem;
        }
        .auth-header-block .auth-tag {
            font-size: 0.74rem;
            font-weight: 700;
            color: var(--brand-primary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            display: inline-block;
            margin-bottom: 4px;
        }
        .auth-header-block h2 {
            font-family: var(--font-display);
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--brand-navy);
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }
        .auth-header-block p {
            color: var(--text-muted);
            font-size: 0.86rem;
            margin: 0;
        }

        /* Form Inputs */
        .form-group-pro {
            margin-bottom: 1.15rem;
        }
        .form-label-pro {
            font-size: 0.82rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .input-wrapper-pro {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon-lead {
            position: absolute;
            left: 12px;
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s;
        }
        .form-control-pro {
            width: 100%;
            height: 44px;
            padding: 0.5rem 0.85rem 0.5rem 2.4rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: #0f172a;
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 9px;
            transition: all 0.2s ease;
        }
        .form-control-pro:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3.5px rgba(21, 94, 239, 0.12);
            outline: none;
        }
        .form-control-pro:focus + .input-icon-lead,
        .input-wrapper-pro:focus-within .input-icon-lead {
            color: var(--brand-primary);
        }

        .btn-toggle-pw-pro {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1rem;
            cursor: pointer;
            padding: 3px 5px;
            border-radius: 6px;
            transition: color 0.2s;
        }
        .btn-toggle-pw-pro:hover, .btn-toggle-pw-pro:focus {
            color: var(--brand-primary);
            outline: 2px solid var(--brand-primary);
        }

        /* Submit Button */
        .btn-brand-primary {
            width: 100%;
            height: 46px;
            background: var(--brand-primary);
            color: #ffffff;
            font-family: var(--font-display);
            font-size: 0.94rem;
            font-weight: 700;
            border: none;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(21, 94, 239, 0.22);
            transition: all 0.2s ease;
        }
        .btn-brand-primary:hover, .btn-brand-primary:focus {
            background: var(--brand-primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(21, 94, 239, 0.3);
            color: #ffffff;
            outline: 2px solid var(--brand-navy);
        }

        /* Institutional Footer */
        .inst-footer {
            background: #ffffff;
            border-top: 1px solid var(--brand-border);
            padding: 0.45rem 2rem;
            flex-shrink: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.74rem;
            color: var(--text-muted);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            body {
                height: auto;
                max-height: none;
                overflow-y: auto;
            }
            .main-portal-wrapper {
                flex-direction: column;
                overflow: visible;
            }
            .portal-showcase-panel {
                padding: 2rem 1.5rem;
            }
            .portal-form-panel {
                padding: 2rem 1.5rem;
            }
            .services-showcase-grid {
                grid-template-columns: 1fr;
            }
            .inst-footer {
                flex-direction: column;
                gap: 4px;
                text-align: center;
                padding: 0.75rem 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Top Header -->
    <header class="inst-header d-flex justify-content-between align-items-center" role="banner">
        <a href="{{ url('/') }}" class="inst-brand" aria-label="Beranda SINERGI PLD UIS">
            <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo Universitas Islam Syarif" class="inst-logo">
            <div>
                <div class="inst-text-title">SINERGI • PLD</div>
                <div class="inst-text-subtitle">Pusat Layanan Disabilitas UIS</div>
            </div>
        </a>

        <!-- Accessibility Suite Toolbar -->
        <nav class="a11y-control-group" aria-label="Pusat Kendali Aksesibilitas">
            <span class="text-muted fw-bold d-none d-md-inline me-1" style="font-size: 0.72rem;">
                <i class="bi bi-universal-access me-1" aria-hidden="true"></i> Aksesibilitas:
            </span>
            <button type="button" class="a11y-btn-item" id="btnFontDecr" title="Perkecil Ukuran Huruf" aria-label="Perkecil Huruf">
                <span>A-</span>
            </button>
            <button type="button" class="a11y-btn-item" id="btnFontReset" title="Ukuran Huruf Standar" aria-label="Reset Ukuran Huruf">
                <span>A</span>
            </button>
            <button type="button" class="a11y-btn-item" id="btnFontIncr" title="Perbesar Ukuran Huruf" aria-label="Perbesar Huruf">
                <span>A+</span>
            </button>
            <button type="button" class="a11y-btn-item" id="btnContrast" title="Alihkan Mode Kontras Tinggi" aria-label="Mode Kontras Tinggi">
                <i class="bi bi-circle-half" aria-hidden="true"></i> <span class="d-none d-sm-inline">Kontras</span>
            </button>
            <button type="button" class="a11y-btn-item" id="btnDyslexic" title="Font Ramah Disleksia" aria-label="Font Disleksia">
                <i class="bi bi-fonts" aria-hidden="true"></i> <span class="d-none d-sm-inline">Disleksia</span>
            </button>
            <button type="button" class="a11y-btn-item" id="btnSpeakPage" title="Bacakan Halaman Ini (Text to Speech)" aria-label="Bacakan Teks Halaman Ini">
                <i class="bi bi-volume-up-fill" id="speakIcon" aria-hidden="true"></i> <span class="d-none d-sm-inline">Audio</span>
            </button>
        </nav>
    </header>

    <!-- Main Workspace Split Layout (100% Height Single Screen Viewport) -->
    <main class="main-portal-wrapper" role="main">

        <!-- Left Showcase Column -->
        <section class="portal-showcase-panel" aria-label="Informasi Pusat Layanan Disabilitas">
            <div>
                <div class="showcase-badge-pill">
                    <div class="pulse-dot"></div>
                    <span>Standar Aksesibilitas WCAG 2.1 Level AA</span>
                </div>

                <h1 class="showcase-title">
                    Sistem Pendataan, Penilaian, Asesmen <br>
                    <span class="highlight-teal">dan Pelacakan Karir Lulusan Inklusif</span>
                </h1>

                <p class="showcase-desc">
                    Portal terpadu <strong>SINERGI PLD UIS</strong> dirancang untuk mendukung pendataan komprehensif, evaluasi pembelajaran adaptif, asesmen kebutuhan khusus, serta pelacakan karir lulusan mahasiswa disabilitas secara terintegrasi.
                </p>

                <!-- 4 Pillars Grid -->
                <div class="services-showcase-grid" role="list">
                    <div class="service-pill-item" role="listitem">
                        <div class="service-icon-box">
                            <i class="bi bi-person-vcard-fill" aria-hidden="true"></i>
                        </div>
                        <div class="service-info">
                            <h4>Sistem Pendataan</h4>
                            <p>Registrasi profil, pemetaan ragam disabilitas, dan data kebutuhan akomodasi.</p>
                        </div>
                    </div>

                    <div class="service-pill-item" role="listitem">
                        <div class="service-icon-box">
                            <i class="bi bi-journal-check" aria-hidden="true"></i>
                        </div>
                        <div class="service-info">
                            <h4>Penilaian Pembelajaran</h4>
                            <p>Monitoring capaian akademik adaptif & evaluasi belajar ramah inklusi.</p>
                        </div>
                    </div>

                    <div class="service-pill-item" role="listitem">
                        <div class="service-icon-box">
                            <i class="bi bi-clipboard2-pulse-fill" aria-hidden="true"></i>
                        </div>
                        <div class="service-info">
                            <h4>Asesmen Kebutuhan</h4>
                            <p>Identifikasi sarana prasarana, alat bantu & rekomendasi akomodasi.</p>
                        </div>
                    </div>

                    <div class="service-pill-item" role="listitem">
                        <div class="service-icon-box">
                            <i class="bi bi-briefcase-fill" aria-hidden="true"></i>
                        </div>
                        <div class="service-info">
                            <h4>Pelacakan Karir Lulusan</h4>
                            <p>Tracer study alumni inklusif, kesiapan kerja & kemitraan industri.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Showcase Stats -->
            <div class="showcase-stats-bar">
                <div class="stat-item-col">
                    <h3>100%</h3>
                    <p>Pendataan Terpadu</p>
                </div>
                <div class="stat-item-col">
                    <h3>Asesmen</h3>
                    <p>Kebutuhan Individual</p>
                </div>
                <div class="stat-item-col">
                    <h3>Karir</h3>
                    <p>Tracer Study Inklusif</p>
                </div>
            </div>
        </section>

        <!-- Right Login Form Column -->
        <section class="portal-form-panel" aria-label="Form Masuk Pengguna">
            <div style="max-width: 420px; width: 100%; margin: auto;">

                <div class="auth-header-block">
                    <span class="auth-tag">
                        <i class="bi bi-shield-check me-1" aria-hidden="true"></i> Portal Layanan Inklusi
                    </span>
                    <h2>Masuk ke Akun Anda</h2>
                    <p>Silakan masuk menggunakan akun civitas akademika untuk mengakses seluruh layanan Pusat Layanan Disabilitas.</p>
                </div>

                <!-- Error Messages Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3 py-2" role="alert" style="border-radius: 8px; background: #fef2f2; color: #991b1b; border-left: 3px solid #ef4444 !important;">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong style="font-size: 0.85rem;">Gagal Masuk</strong>
                        </div>
                        <ul class="mb-0 ps-3" style="font-size: 0.78rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.proses') }}" novalidate id="loginForm">
                    @csrf

                    <!-- Email Input -->
                    <div class="form-group-pro">
                        <label for="inputEmail" class="form-label-pro">
                            <span>Alamat Email</span>
                        </label>
                        <div class="input-wrapper-pro">
                            <i class="bi bi-envelope input-icon-lead" aria-hidden="true"></i>
                            <input type="email" name="email" id="inputEmail" class="form-control-pro"
                                placeholder="nama@uis.ac.id" value="{{ old('email') }}" required autocomplete="email">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="form-group-pro mb-4">
                        <label for="inputPassword" class="form-label-pro">
                            <span>Kata Sandi</span>
                            <a href="#" class="text-decoration-none small text-primary fw-semibold" tabindex="0">Lupa Sandi?</a>
                        </label>
                        <div class="input-wrapper-pro">
                            <i class="bi bi-lock input-icon-lead" aria-hidden="true"></i>
                            <input type="password" name="password" id="inputPassword" class="form-control-pro"
                                placeholder="Masukkan kata sandi" required autocomplete="current-password">
                            <button type="button" class="btn-toggle-pw-pro" id="btnTogglePassword" aria-label="Lihat atau sembunyikan kata sandi">
                                <i class="bi bi-eye" id="pwToggleIcon" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-brand-primary" id="btnSubmitLogin">
                        <span>Masuk ke Akun</span>
                        <i class="bi bi-arrow-right-short fs-4" aria-hidden="true"></i>
                    </button>
                </form>

            </div>
        </section>

    </main>

    <!-- Official Institutional Footer -->
    <footer class="inst-footer" role="contentinfo">
        <div>
            © {{ date('Y') }} <strong>Pusat Layanan Disabilitas (PLD)</strong> • Universitas Islam Syarif.
        </div>
        <div class="d-flex gap-2">
            <span>Standar Aksesibilitas ISO/IEC 40500</span>
            <span>•</span>
            <a href="#" class="text-decoration-none text-muted">Kebijakan Privasi</a>
            <span>•</span>
            <a href="#" class="text-decoration-none text-muted">Panduan Aksesibilitas</a>
        </div>
    </footer>

    <!-- Vendor Scripts -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Password Visibility Toggle
        const btnTogglePw = document.getElementById('btnTogglePassword');
        const inputPw = document.getElementById('inputPassword');
        const pwToggleIcon = document.getElementById('pwToggleIcon');

        btnTogglePw?.addEventListener('click', function () {
            const isPassword = inputPw.getAttribute('type') === 'password';
            inputPw.setAttribute('type', isPassword ? 'text' : 'password');
            pwToggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            this.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });

        // Accessibility Suite: Font Size Scaling
        let baseFontSize = 15;
        const rootDoc = document.documentElement;

        document.getElementById('btnFontIncr')?.addEventListener('click', () => {
            if (baseFontSize < 20) {
                baseFontSize += 1.5;
                rootDoc.style.setProperty('--base-font-size', baseFontSize + 'px');
            }
        });

        document.getElementById('btnFontDecr')?.addEventListener('click', () => {
            if (baseFontSize > 12) {
                baseFontSize -= 1.5;
                rootDoc.style.setProperty('--base-font-size', baseFontSize + 'px');
            }
        });

        document.getElementById('btnFontReset')?.addEventListener('click', () => {
            baseFontSize = 15;
            rootDoc.style.setProperty('--base-font-size', '15px');
        });

        // Accessibility Suite: High Contrast
        const btnContrast = document.getElementById('btnContrast');
        btnContrast?.addEventListener('click', function () {
            document.body.classList.toggle('theme-high-contrast');
            const isContrast = document.body.classList.contains('theme-high-contrast');
            this.classList.toggle('active', isContrast);
            localStorage.setItem('pld_contrast', isContrast ? '1' : '0');
        });
        if (localStorage.getItem('pld_contrast') === '1') {
            document.body.classList.add('theme-high-contrast');
            btnContrast?.classList.add('active');
        }

        // Accessibility Suite: Dyslexic Font Mode
        const btnDyslexic = document.getElementById('btnDyslexic');
        btnDyslexic?.addEventListener('click', function () {
            document.body.classList.toggle('font-dyslexic');
            const isDyslexic = document.body.classList.contains('font-dyslexic');
            this.classList.toggle('active', isDyslexic);
            localStorage.setItem('pld_dyslexic', isDyslexic ? '1' : '0');
        });
        if (localStorage.getItem('pld_dyslexic') === '1') {
            document.body.classList.add('font-dyslexic');
            btnDyslexic?.classList.add('active');
        }

        // Accessibility Suite: Text-to-Speech (Audio Reader)
        let isSpeaking = false;
        const btnSpeak = document.getElementById('btnSpeakPage');
        const speakIcon = document.getElementById('speakIcon');

        btnSpeak?.addEventListener('click', function () {
            if (!('speechSynthesis' in window)) {
                alert('Browser Anda belum mendukung Web Speech API.');
                return;
            }

            if (isSpeaking) {
                window.speechSynthesis.cancel();
                isSpeaking = false;
                speakIcon.className = 'bi bi-volume-up-fill';
                this.classList.remove('active');
                return;
            }

            const textToRead = "Selamat datang di SINERGI, Sistem Pendataan, Penilaian, Asesmen dan Pelacakan Karir Lulusan Inklusif Pusat Layanan Disabilitas UIS. Silakan masukkan alamat email dan kata sandi Anda untuk masuk ke sistem.";
            const utterance = new SpeechSynthesisUtterance(textToRead);
            utterance.lang = 'id-ID';
            utterance.rate = 0.95;

            utterance.onend = function () {
                isSpeaking = false;
                speakIcon.className = 'bi bi-volume-up-fill';
                btnSpeak.classList.remove('active');
            };

            utterance.onerror = function () {
                isSpeaking = false;
                speakIcon.className = 'bi bi-volume-up-fill';
                btnSpeak.classList.remove('active');
            };

            window.speechSynthesis.speak(utterance);
            isSpeaking = true;
            speakIcon.className = 'bi bi-stop-fill';
            this.classList.add('active');
        });
    </script>

</body>

</html>
