<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DentalCare') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --teal: #1d49b0;
            --teal-light: #1045bf;
            --teal-dark: #11368b;
            --cream: #f7f4ef;
            --warm-gray: #6b6560;
            --text-dark: #1a1a18;
            --border: #e2ded8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            background: #fff;
        }

        h1, h2, h3, h4 {
            font-family: 'DM Serif Display', serif;
            font-weight: 400;
        }

        /* ── TOP BAR ── */
        .topbar {
            background: var(--teal-dark);
            color: #cde8e4;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.02em;
        }
        .topbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.55rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.4rem;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .topbar-left a, .topbar-left span {
            color: #cde8e4;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            transition: color 0.2s;
        }
        .topbar-left a:hover { color: #fff; }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .topbar-right a {
            color: #cde8e4;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            transition: all 0.2s;
        }
        .topbar-right a:hover { background: rgba(255,255,255,0.15); color: #fff; border-color: rgba(255,255,255,0.5); }
        .topbar-right svg { width: 12px; height: 12px; }

        /* ── NAV ── */
        .nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            border-bottom: 1px solid var(--border);
        }
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .nav-logo-mark {
            width: 38px;
            height: 38px;
            background: var(--teal);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .nav-logo-mark svg { width: 20px; height: 20px; color: #fff; }
        .nav-logo-text {
            font-family: 'DM Serif Display', serif;
            font-size: 1.3rem;
            color: var(--text-dark);
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--warm-gray);
            font-size: 0.92rem;
            font-weight: 500;
            transition: color 0.2s;
            position: relative;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--teal);
            transform: scaleX(0);
            transition: transform 0.25s;
        }
        .nav-links a:hover { color: var(--teal); }
        .nav-links a:hover::after { transform: scaleX(1); }
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .btn-ghost {
            padding: 0.5rem 1.1rem;
            color: var(--teal);
            font-weight: 600;
            font-size: 0.9rem;
            border: 1.5px solid var(--teal);
            border-radius: 8px;
            background: transparent;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-ghost:hover { background: var(--teal); color: #fff; }
        .btn-solid {
            padding: 0.55rem 1.3rem;
            background: var(--teal);
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            transition: background 0.2s;
            cursor: pointer;
        }
        .btn-solid:hover { background: var(--teal-dark); }
        .nav-hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.4rem;
        }
        .nav-hamburger svg { width: 24px; height: 24px; color: var(--text-dark); }

        /* Mobile Nav */
        .mobile-nav {
            display: none;
            background: #fff;
            border-top: 1px solid var(--border);
            padding: 1rem 1.5rem;
        }
        .mobile-nav a {
            display: block;
            padding: 0.7rem 0;
            color: var(--warm-gray);
            font-weight: 500;
            text-decoration: none;
            border-bottom: 1px solid var(--border);
            transition: color 0.2s;
        }
        .mobile-nav a:hover { color: var(--teal); }
        .mobile-nav .btn-solid { display: block; text-align: center; margin-top: 1rem; }
        .mobile-nav.open { display: block; }

        /* ── HERO ── */
        .hero {
            position: relative;
            min-height: 88vh;
            overflow: hidden;
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
        }
        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, rgba(6, 30, 90, 0.82) 0%, rgba(24, 86, 219, 0.65) 50%, rgba(0,0,0,0.25) 100%);
        }
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 6rem 1.5rem;
            text-align: left;
        }
        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(8px);
            color: #d4f0ec;
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.35rem 0.9rem;
            border-radius: 100px;
            margin-bottom: 1.5rem;
        }
        .hero-pill-dot {
            width: 7px; height: 7px;
            background: #5ef0d4;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(0.85); }
        }
        .hero h1 {
            font-size: clamp(2.6rem, 5vw, 4rem);
            color: #fff;
            line-height: 1.1;
            max-width: 620px;
            margin-bottom: 1.2rem;
        }
        .hero h1 em {
            font-style: italic;
            color: #a8f0e0;
        }
        .hero p {
            color: rgba(255,255,255,0.8);
            font-size: 1.05rem;
            line-height: 1.7;
            max-width: 500px;
            margin-bottom: 2rem;
        }
        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .btn-hero-primary {
            padding: 0.85rem 2rem;
            background: #fff;
            color: var(--teal-dark);
            font-weight: 700;
            font-size: 0.95rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,0.2); }
        .btn-hero-outline {
            padding: 0.85rem 2rem;
            background: transparent;
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-hero-outline:hover { background: rgba(255,255,255,0.1); border-color: #fff; }

        /* Hero stats */
        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }
        .hero-stat {
            text-align: left;
        }
        .hero-stat-num {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            color: #fff;
            line-height: 1;
        }
        .hero-stat-label {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.65);
            margin-top: 0.2rem;
        }
        .hero-stat-divider {
            width: 1px;
            background: rgba(255,255,255,0.25);
            align-self: stretch;
        }

        /* ── SECTION COMMON ── */
        .section {
            padding: 5rem 1.5rem;
        }
        .section-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-tag {
            display: inline-block;
            color: var(--teal);
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }
        .section-title {
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            color: var(--text-dark);
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }
        .section-sub {
            color: var(--warm-gray);
            font-size: 1rem;
            line-height: 1.7;
            max-width: 540px;
        }
        .section-header { margin-bottom: 3rem; }
        .section-header.center { text-align: center; }
        .section-header.center .section-sub { margin: 0 auto; }

        /* ── WHY US ── */
        .why-bg { background: var(--cream); }
        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }
        .why-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem 1.75rem;
            border: 1px solid var(--border);
            transition: box-shadow 0.25s, transform 0.25s;
        }
        .why-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.08); transform: translateY(-3px); }
        .why-icon {
            width: 52px;
            height: 52px;
            background: #e8f5f2;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }
        .why-icon svg { width: 24px; height: 24px; color: var(--teal); }
        .why-card h3 {
            font-size: 1.05rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }
        .why-card p { font-size: 0.9rem; color: var(--warm-gray); line-height: 1.6; }

        /* ── SERVICES ── */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.25rem;
        }
        .service-card {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.25s;
        }
        .service-card:hover { box-shadow: 0 10px 35px rgba(0,0,0,0.1); }
        .service-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .service-body {
            padding: 1.5rem;
            flex: 1;
        }
        .service-body h3 {
            font-size: 1.15rem;
            margin-bottom: 0.5rem;
        }
        .service-body p { font-size: 0.88rem; color: var(--warm-gray); line-height: 1.6; }

        /* ── HOW IT WORKS ── */
        .how-bg { background: var(--cream); }
        .how-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        .how-steps { display: flex; flex-direction: column; gap: 1.5rem; }
        .how-step {
            display: flex;
            gap: 1.25rem;
            align-items: flex-start;
            padding: 1.5rem;
            border-radius: 14px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
        }
        .how-step:hover, .how-step.active {
            background: #fff;
            border-color: var(--border);
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        .how-step-num {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            color: var(--teal);
            line-height: 1;
            min-width: 40px;
        }
        .how-step h3 { font-size: 1.05rem; margin-bottom: 0.4rem; }
        .how-step p { font-size: 0.87rem; color: var(--warm-gray); line-height: 1.6; }
        .how-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        }

        /* ── TESTIMONIAL ── */
        .testimonial-bg { background: var(--teal-dark); }
        .testimonial-inner {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }
        .quote-mark {
            font-family: 'DM Serif Display', serif;
            font-size: 5rem;
            color: rgba(255,255,255,0.15);
            line-height: 0.5;
            margin-bottom: 1.5rem;
        }
        .testimonial-text {
            font-size: 1.2rem;
            line-height: 1.8;
            color: rgba(255,255,255,0.85);
            margin-bottom: 2rem;
            font-style: italic;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .testimonial-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.3);
        }
        .testimonial-name {
            font-family: 'DM Serif Display', serif;
            font-size: 1.1rem;
            color: #fff;
        }
        .testimonial-role { font-size: 0.82rem; color: rgba(255,255,255,0.55); }

        /* ── FAQ ── */
        .faq-list { max-width: 720px; margin: 0 auto; }
        .faq-item { border-bottom: 1px solid var(--border); }
        .faq-q {
            width: 100%;
            background: none;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 0;
            font-family: 'DM Serif Display', serif;
            font-size: 1.05rem;
            color: var(--text-dark);
            cursor: pointer;
            text-align: left;
            gap: 1rem;
            transition: color 0.2s;
        }
        .faq-q:hover { color: var(--teal); }
        .faq-q svg { width: 18px; height: 18px; flex-shrink: 0; transition: transform 0.3s; }
        .faq-q.open svg { transform: rotate(45deg); color: var(--teal); }
        .faq-a {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, padding 0.35s;
        }
        .faq-a.open { max-height: 300px; padding-bottom: 1.25rem; }
        .faq-a p { font-size: 0.92rem; color: var(--warm-gray); line-height: 1.7; }

        /* ── TEAM ── */
        .team-bg { background: var(--cream); }
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }
        .team-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border);
            text-align: center;
            transition: box-shadow 0.25s, transform 0.25s;
        }
        .team-card:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.09); transform: translateY(-3px); }
        .team-img {
            width: 100%;
            height: 230px;
            object-fit: cover;
        }
        .team-body { padding: 1.25rem; }
        .team-body h3 { font-size: 1.1rem; margin-bottom: 0.2rem; }
        .team-body p { font-size: 0.82rem; color: var(--teal); font-weight: 500; }

        /* ── WORKING HOURS SIDEBAR ── */
        .info-section {
            background: var(--teal);
            color: #fff;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
        }
        .hours-list { list-style: none; }
        .hours-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.7rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            font-size: 0.9rem;
        }
        .hours-list li:last-child { border-bottom: none; }
        .hours-day { color: rgba(255,255,255,0.7); }
        .hours-time { font-weight: 600; }
        .contact-items { display: flex; flex-direction: column; gap: 1.25rem; }
        .contact-item { display: flex; gap: 1rem; align-items: flex-start; }
        .contact-item-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .contact-item-icon svg { width: 18px; height: 18px; color: #fff; }
        .contact-item-label { font-size: 0.75rem; color: rgba(255,255,255,0.6); margin-bottom: 0.15rem; text-transform: uppercase; letter-spacing: 0.06em; }
        .contact-item-value { font-size: 0.95rem; font-weight: 500; }
        .contact-item-value a { color: #fff; text-decoration: none; }
        .contact-item-value a:hover { text-decoration: underline; }
        .info-section .section-title { color: #fff; }
        .info-section .section-tag { color: rgba(255,255,255,0.6); }

        /* ── LOGIN SECTION ── */
        .login-bg { background: #fff; }
        .login-wrap {
            max-width: 460px;
            margin: 0 auto;
        }
        .login-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        }
        .login-header {
            background: var(--teal);
            padding: 2.5rem 2rem;
            text-align: center;
        }
        .login-header h2 {
            color: #fff;
            font-size: 1.7rem;
            margin-bottom: 0.25rem;
        }
        .login-header p { color: rgba(255,255,255,0.75); font-size: 0.9rem; }
        .login-body { padding: 2rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.45rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.92rem;
            color: var(--text-dark);
            background: #fafaf9;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(10,123,107,0.12);
            background: #fff;
        }
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--warm-gray);
            cursor: pointer;
        }
        .form-check input[type="checkbox"] {
            accent-color: var(--teal);
            width: 15px;
            height: 15px;
        }
        .form-link { color: var(--teal); font-weight: 600; text-decoration: none; }
        .form-link:hover { text-decoration: underline; }
        .btn-form {
            width: 100%;
            padding: 0.85rem;
            background: var(--teal);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s;
            letter-spacing: 0.02em;
        }
        .btn-form:hover { background: var(--teal-dark); }
        .form-footer {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.85rem;
            color: var(--warm-gray);
        }
        .demo-box {
            margin-top: 1.5rem;
            padding: 1rem;
            background: var(--cream);
            border-radius: 10px;
            border: 1px solid var(--border);
        }
        .demo-box p { font-size: 0.78rem; font-weight: 700; color: var(--warm-gray); letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 0.5rem; text-align: center; }
        .demo-box span { font-size: 0.82rem; color: var(--text-dark); display: block; line-height: 1.8; }
        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.2rem;
        }
        .error-box p { font-size: 0.85rem; color: #dc2626; }

        /* ── FOOTER ── */
        .footer { background: var(--text-dark); color: #fff; }
        .footer-top {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 1.5rem 2rem;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 3rem;
        }
        .footer-brand p { font-size: 0.88rem; color: rgba(255,255,255,0.5); line-height: 1.7; margin-top: 1rem; }
        .footer-brand .nav-logo-text { color: #fff; }
        .footer h5 { font-family: 'DM Serif Display', serif; font-size: 1rem; margin-bottom: 1rem; color: rgba(255,255,255,0.9); }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 0.55rem; }
        .footer-links a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 0.88rem; transition: color 0.2s; }
        .footer-links a:hover { color: #fff; }
        .footer-contact-item { display: flex; gap: 0.6rem; align-items: flex-start; margin-bottom: 0.75rem; }
        .footer-contact-item svg { width: 16px; height: 16px; color: var(--teal-light); flex-shrink: 0; margin-top: 2px; }
        .footer-contact-item span { font-size: 0.85rem; color: rgba(255,255,255,0.55); line-height: 1.5; }
        .footer-social { display: flex; gap: 0.6rem; margin-top: 1.25rem; }
        .footer-social a {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: all 0.2s;
        }
        .footer-social a:hover { background: var(--teal); border-color: var(--teal); color: #fff; }
        .footer-social svg { width: 14px; height: 14px; }
        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.25rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.35);
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .nav-links, .nav-actions { display: none; }
            .nav-hamburger { display: flex; }
            .how-grid { grid-template-columns: 1fr; }
            .how-image { display: none; }
            .info-grid { grid-template-columns: 1fr; gap: 2rem; }
            .footer-top { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 600px) {
            .topbar-left { flex-wrap: wrap; gap: 0.5rem; }
            .hero h1 { font-size: 2.2rem; }
            .hero-stats { gap: 1.25rem; }
            .footer-top { grid-template-columns: 1fr; gap: 2rem; }
            .footer-bottom { flex-direction: column; text-align: center; }
        }
    </style>
</head>

<body>

<!-- ── TOP BAR ── -->
<div class="topbar">
    <div class="topbar-inner">
        <div class="topbar-left">
            <a href="tel:+6321234567">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                +63 (2) 123-4567
            </a>
            <span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                123 Dental St, Manila, Philippines
            </span>
            <span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Mon–Sat: 9:00 AM – 6:00 PM
            </span>
        </div>
        <div class="topbar-right">
            <a href="https://facebook.com" aria-label="Facebook">
                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
            </a>
            <a href="https://instagram.com" aria-label="Instagram">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="2"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" stroke-width="2"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-width="2"/></svg>
            </a>
            <a href="https://twitter.com" aria-label="Twitter">
                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
            </a>
        </div>
    </div>
</div>

<!-- ── NAV ── -->
<nav class="nav" id="main-nav">
    <div class="nav-inner">
        <a href="#home" class="nav-logo">
            <div class="nav-logo-mark">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>
            </div>
            <span class="nav-logo-text">DentalCare</span>
        </a>

        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#team">Our Dentists</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#faq">FAQ</a></li>
        </ul>

        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn-ghost">Login</a>
            <a href="{{ route('register') }}" class="btn-solid">Book Now</a>
        </div>

        <button class="nav-hamburger" id="mobile-menu-btn" aria-label="Menu">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    <div class="mobile-nav" id="mobile-menu">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#team">Our Dentists</a>
        <a href="#contact">Contact</a>
        <a href="#faq">FAQ</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}" class="btn-solid">Book Now</a>
    </div>
</nav>

<!-- ── HERO ── -->
<section id="home" class="hero">
    <div class="hero-bg">
        <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Dental Clinic">
    </div>
    <div class="hero-content">
        <div class="hero-pill">
            <span class="hero-pill-dot"></span>
            Online consultation available weekends
        </div>
        <h1>Beautiful <em>Smiles</em><br>Start Here</h1>
        <p>DentalCare provides high-quality dental care for the whole family. Our experienced team uses modern technology for comfortable, safe, and effective treatments.</p>
        <div class="hero-buttons">
            <a href="{{ route('register') }}" class="btn-hero-primary">Book Appointment</a>
            <a href="#about" class="btn-hero-outline">Learn More</a>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-num">12+</div>
                <div class="hero-stat-label">Years of experience</div>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <div class="hero-stat-num">8k+</div>
                <div class="hero-stat-label">Happy patients</div>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <div class="hero-stat-num">98%</div>
                <div class="hero-stat-label">Satisfaction rate</div>
            </div>
        </div>
    </div>
</section>

<!-- ── WHY US ── -->
<section id="about" class="section why-bg">
    <div class="section-inner">
        <div class="section-header center">
            <span class="section-tag">Why Choose Us</span>
            <h2 class="section-title">Why You Should Choose Our<br>Dental Service?</h2>
            <p class="section-sub">From our experienced team to our state-of-the-art equipment, we provide exceptional care for all your dental needs.</p>
        </div>
        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3>Affordable Price</h3>
                <p>Dental care that is reasonable and manageable within your budget — quality shouldn't break the bank.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3>Professional Dentists</h3>
                <p>Our certified team of dentists, hygienists, and assistants work together to deliver top-tier care.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3>Satisfactory Service</h3>
                <p>We ensure every patient receives care that meets or exceeds their expectations — every single visit.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3>Easy Scheduling</h3>
                <p>Book appointments online, by phone, or in person. Morning, afternoon, and weekend slots available.</p>
            </div>
        </div>
    </div>
</section>

<!-- ── SERVICES ── -->
<section id="services" class="section">
    <div class="section-inner">
        <div class="section-header center">
            <span class="section-tag">Our Services</span>
            <h2 class="section-title">What Services We Offer</h2>
            <p class="section-sub">From routine check-ups to advanced procedures, we offer a full range of dental services tailored to your needs.</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <img class="service-img" src="https://images.unsplash.com/photo-1588776814546-ec7e6b3bb77e?w=600&q=80" alt="Teeth Checkup">
                <div class="service-body">
                    <h3>Teeth Checkup</h3>
                    <p>A routine dental examination performed by our dentist or hygienist to maintain your oral health and catch issues early.</p>
                </div>
            </div>
            <div class="service-card">
                <img class="service-img" src="https://images.unsplash.com/photo-1606811971618-4486d14f3f99?w=600&q=80" alt="Teeth Whitening">
                <div class="service-body">
                    <h3>Teeth Whitening</h3>
                    <p>Professional whitening procedure that lightens your teeth color and removes stains for a brighter, more confident smile.</p>
                </div>
            </div>
            <div class="service-card">
                <img class="service-img" src="https://images.unsplash.com/photo-1609840114035-3c981b782dfe?w=600&q=80" alt="Dental Braces">
                <div class="service-body">
                    <h3>Dental Braces</h3>
                    <p>Orthodontic treatment to straighten teeth and correct bite issues using modern braces and clear aligner systems.</p>
                </div>
            </div>
            <div class="service-card">
                <img class="service-img" src="https://images.unsplash.com/photo-1598256989800-fe5f95da9787?w=600&q=80" alt="Dental Implants">
                <div class="service-body">
                    <h3>Dental Implants</h3>
                    <p>Permanent tooth replacement solutions that look, feel, and function like natural teeth — built to last a lifetime.</p>
                </div>
            </div>
            <div class="service-card">
                <img class="service-img" src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600&q=80" alt="Dental Filling">
                <div class="service-body">
                    <h3>Dental Filling</h3>
                    <p>Repairing teeth damaged by decay or cavities using safe, tooth-colored materials that blend seamlessly with your smile.</p>
                </div>
            </div>
            <div class="service-card">
                <img class="service-img" src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=600&q=80" alt="Cosmetic Dentistry">
                <div class="service-body">
                    <h3>Cosmetic Dentistry</h3>
                    <p>Procedures designed to improve the appearance of your teeth, gums, and overall smile with stunning results.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── HOW IT WORKS ── -->
<section class="section how-bg">
    <div class="section-inner">
        <div class="how-grid">
            <div>
                <div class="section-header">
                    <span class="section-tag">Process</span>
                    <h2 class="section-title">How to Get Treatment<br>at DentalCare?</h2>
                    <p class="section-sub">Simple steps from booking to your perfect smile. We make the experience as smooth as possible.</p>
                </div>
                <div class="how-steps">
                    <div class="how-step active">
                        <span class="how-step-num">01</span>
                        <div>
                            <h3>Make an Appointment</h3>
                            <p>Fill out our online form, call us directly, or stop by the clinic in person. Have your insurance details ready — we'll confirm your slot quickly.</p>
                        </div>
                    </div>
                    <div class="how-step">
                        <span class="how-step-num">02</span>
                        <div>
                            <h3>Visit the Clinic</h3>
                            <p>Arrive at your scheduled time. Our friendly front desk will welcome you and guide you through check-in comfortably.</p>
                        </div>
                    </div>
                    <div class="how-step">
                        <span class="how-step-num">03</span>
                        <div>
                            <h3>Free Consultation</h3>
                            <p>Our dentist will assess your dental health, discuss your goals, and recommend the best treatment plan at no extra cost.</p>
                        </div>
                    </div>
                    <div class="how-step">
                        <span class="how-step-num">04</span>
                        <div>
                            <h3>Get a Charming Smile</h3>
                            <p>Walk out with the smile you've always wanted. We'll schedule follow-ups and provide aftercare guidance to keep it perfect.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="how-image">
                <img src="https://images.unsplash.com/photo-1607613009820-a29f7bb81c04?w=700&q=80" alt="Appointment process">
            </div>
        </div>
    </div>
</section>

<!-- ── TESTIMONIAL ── -->
<section class="section testimonial-bg">
    <div class="section-inner">
        <div class="testimonial-inner">
            <div class="quote-mark">"</div>
            <p class="testimonial-text">I recently visited DentalCare and was highly impressed by the exceptional care and service. The warm and friendly staff, along with the professionalism of our dentists, made my visit outstanding. The state-of-the-art facilities and personalized care put me completely at ease. My dental health has significantly improved — I couldn't be happier.</p>
            <div class="testimonial-author">
                <img class="testimonial-avatar" src="https://images.unsplash.com/photo-1494790108755-2616b0e2e2b0?w=100&q=80" alt="Julie Radhina">
                <div>
                    <div class="testimonial-name">Julie Radhina</div>
                    <div class="testimonial-role">Patient &amp; Brand Owner</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── TEAM ── -->
<section id="team" class="section team-bg">
    <div class="section-inner">
        <div class="section-header center">
            <span class="section-tag">Our Team</span>
            <h2 class="section-title">Meet Our Expert Dentists</h2>
            <p class="section-sub">A group of highly trained dentists, hygienists, and staff members committed to giving you the best care at the most convenient time.</p>
        </div>
        <div class="team-grid">
            <div class="team-card">
                <img class="team-img" src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=400&q=80" alt="Dr. Reza Mahendra">
                <div class="team-body">
                    <h3>Dr. Reza Mahendra</h3>
                    <p>Orthodontist</p>
                </div>
            </div>
            <div class="team-card">
                <img class="team-img" src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&q=80" alt="Dr. Marliana Sari">
                <div class="team-body">
                    <h3>Dr. Marliana Sari</h3>
                    <p>General Dentist</p>
                </div>
            </div>
            <div class="team-card">
                <img class="team-img" src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?w=400&q=80" alt="Dr. Daniel Thompson">
                <div class="team-body">
                    <h3>Dr. Daniel Thompson</h3>
                    <p>General Dentist</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── FAQ ── -->
<section id="faq" class="section">
    <div class="section-inner">
        <div class="section-header center">
            <span class="section-tag">FAQ</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-sub">Have a concern? Get answers to the most common dental questions anytime, anywhere.</p>
        </div>
        <div class="faq-list">
            <div class="faq-item">
                <button class="faq-q open" data-faq="0">
                    What dental services does your clinic offer?
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/></svg>
                </button>
                <div class="faq-a open">
                    <p>We offer routine check-ups, cleanings, fillings, crowns, bridges, implants, root canals, extractions, teeth whitening, braces, and cosmetic procedures — a complete range for the whole family.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" data-faq="1">
                    How often should I visit the dentist?
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/></svg>
                </button>
                <div class="faq-a">
                    <p>We recommend visiting every six months for a routine cleaning and check-up. Patients with specific dental conditions may need more frequent visits as advised by their dentist.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" data-faq="2">
                    Do you accept dental insurance?
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/></svg>
                </button>
                <div class="faq-a">
                    <p>Yes, we accept most major dental insurance plans. Our front desk team will verify your coverage and help maximize your benefits before any procedure begins.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" data-faq="3">
                    Are dental procedures painful?
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/></svg>
                </button>
                <div class="faq-a">
                    <p>Patient comfort is our top priority. We use modern anesthesia and sedation options to ensure procedures are as painless as possible. Most patients report minimal discomfort during and after treatment.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" data-faq="4">
                    How can I schedule an appointment?
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/></svg>
                </button>
                <div class="faq-a">
                    <p>You can book online through our website, call us at +63 (2) 123-4567, send us an email, or walk in during clinic hours. We'll find a time that works best for you.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── WORKING HOURS & CONTACT ── -->
<section id="contact" class="section info-section">
    <div class="section-inner">
        <div class="info-grid">
            <div>
                <span class="section-tag">Working Hours</span>
                <h2 class="section-title" style="color:#fff; margin-bottom:1.5rem;">Clinic Schedule</h2>
                <ul class="hours-list">
                    <li><span class="hours-day">Monday</span><span class="hours-time">08:00 – 20:00</span></li>
                    <li><span class="hours-day">Tuesday</span><span class="hours-time">08:00 – 20:00</span></li>
                    <li><span class="hours-day">Wednesday</span><span class="hours-time">08:00 – 20:00</span></li>
                    <li><span class="hours-day">Thursday</span><span class="hours-time">08:00 – 20:00</span></li>
                    <li><span class="hours-day">Friday</span><span class="hours-time">10:00 – 16:00</span></li>
                    <li><span class="hours-day">Saturday</span><span class="hours-time">10:00 – 16:00</span></li>
                    <li><span class="hours-day">Sunday</span><span class="hours-time" style="color:rgba(255,255,255,0.4)">Closed</span></li>
                </ul>
                <div style="margin-top:2rem;">
                    <a href="{{ route('register') }}" class="btn-hero-primary" style="display:inline-block">Make an Appointment</a>
                </div>
            </div>
            <div>
                <span class="section-tag">Get in Touch</span>
                <h2 class="section-title" style="color:#fff; margin-bottom:1.5rem;">Contact Information</h2>
                <div class="contact-items">
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <div class="contact-item-label">Emergency &amp; Booking</div>
                            <div class="contact-item-value"><a href="tel:+6321234567">+63 (2) 123-4567</a><br><a href="tel:+6321234568">+63 (2) 123-4568</a></div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="contact-item-label">Address</div>
                            <div class="contact-item-value">123 Dental Street, Manila,<br>Philippines 1000</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="contact-item-label">Email Us</div>
                            <div class="contact-item-value">
                                <a href="mailto:info@dentalcare.com">info@dentalcare.com</a><br>
                                <a href="mailto:emergencies@dentalcare.com">emergencies@dentalcare.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ── FOOTER ── -->
<footer class="footer">
    <div class="footer-top">
        <div class="footer-brand">
            <a href="#home" class="nav-logo">
                <div class="nav-logo-mark">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>
                </div>
                <span class="nav-logo-text">DentalCare</span>
            </a>
            <p>Your trusted partner for all your dental health needs. Quality care, beautiful smiles — for the whole family.</p>
            <div class="footer-social">
                <a href="https://facebook.com" aria-label="Facebook">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                </a>
                <a href="https://instagram.com" aria-label="Instagram">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="2"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" stroke-width="2"/></svg>
                </a>
                <a href="https://twitter.com" aria-label="Twitter">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                </a>
                <a href="https://linkedin.com" aria-label="LinkedIn">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                </a>
            </div>
        </div>
        <div>
            <h5>Quick Links</h5>
            <ul class="footer-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#team">Our Dentists</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
        </div>
        <div>
            <h5>Services</h5>
            <ul class="footer-links">
                <li><a href="#services">General Dentistry</a></li>
                <li><a href="#services">Teeth Whitening</a></li>
                <li><a href="#services">Dental Implants</a></li>
                <li><a href="#services">Orthodontics</a></li>
                <li><a href="#services">Dental Filling</a></li>
                <li><a href="#services">Cosmetic Dentistry</a></li>
            </ul>
        </div>
        <div>
            <h5>Contact Us</h5>
            <div class="footer-contact-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span>+63 (2) 123-4567<br>+63 (2) 123-4568</span>
            </div>
            <div class="footer-contact-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>info@dentalcare.com<br>emergencies@dentalcare.com</span>
            </div>
            <div class="footer-contact-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>123 Dental Street, Manila,<br>Philippines 1000</span>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>&copy; 2026 DentalCare Clinic. All rights reserved.</span>
        <span>Inspired by Medicana Dental Template</span>
    </div>
</footer>

<!-- ── SCRIPTS ── -->
<script>
    // Mobile menu
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('open');
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', function(e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                var offset = document.querySelector('.nav').offsetHeight;
                window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
                document.getElementById('mobile-menu').classList.remove('open');
            }
        });
    });

    // FAQ accordion
    document.querySelectorAll('.faq-q').forEach(btn => {
        btn.addEventListener('click', function() {
            var answer = this.nextElementSibling;
            var isOpen = this.classList.contains('open');

            // Close all
            document.querySelectorAll('.faq-q').forEach(b => {
                b.classList.remove('open');
                b.nextElementSibling.classList.remove('open');
            });

            // Toggle clicked
            if (!isOpen) {
                this.classList.add('open');
                answer.classList.add('open');
            }
        });
    });

    // How-it-works step highlight
    document.querySelectorAll('.how-step').forEach(step => {
        step.addEventListener('click', function() {
            document.querySelectorAll('.how-step').forEach(s => s.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>

</body>
</html>