<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: 'Inter', sans-serif;
                background: #f3f4f6;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
            }

            .auth-card {
                display: flex;
                width: 100%;
                max-width: 860px;
                background: #fff;
                border-radius: 24px;
                box-shadow: 0 8px 40px rgba(0,0,0,0.10);
                overflow: hidden;
                min-height: 540px;
            }

            /* --- Left image panel --- */
            .auth-panel {
                flex: 0 0 40%;
                background: url('/images/auth-panel.jpg') no-repeat center/cover;
                margin: 12px;
                border-radius: 16px;
                padding: 28px 28px 32px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                position: relative;
                overflow: hidden;
            }

            .auth-panel::after {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.55) 100%);
                border-radius: 16px;
                z-index: 0;
            }

            .auth-panel > * { position: relative; z-index: 1; }

            .panel-star {
                font-size: 1.75rem;
                font-weight: 800;
                color: rgba(255,255,255,0.90);
                line-height: 1;
            }

            .panel-tagline-sm {
                font-size: 0.8125rem;
                color: rgba(255,255,255,0.65);
                margin-bottom: 8px;
            }

            .panel-heading {
                font-size: 1.35rem;
                font-weight: 700;
                color: #fff;
                line-height: 1.35;
            }

            /* --- Right form side --- */
            .auth-form-side {
                flex: 1;
                padding: 44px 48px 40px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .form-star {
                font-size: 1.4rem;
                font-weight: 800;
                color: #4f46e5;
                line-height: 1;
                margin-bottom: 6px;
            }

            .auth-title {
                font-size: 1.75rem;
                font-weight: 700;
                color: #111827;
                line-height: 1.2;
                margin-bottom: 6px;
            }

            .auth-subtitle {
                font-size: 0.875rem;
                color: #6b7280;
                line-height: 1.55;
                margin-bottom: 24px;
            }

            .auth-label {
                font-size: 0.875rem;
                font-weight: 600;
                color: #111827;
                display: block;
                margin-bottom: 6px;
            }

            .auth-input-wrap {
                position: relative;
            }

            .auth-input {
                width: 100%;
                padding: 11px 14px;
                border: 1.5px solid #e5e7eb;
                border-radius: 8px;
                font-size: 0.9375rem;
                font-family: 'Inter', sans-serif;
                color: #111827;
                background: #fff;
                outline: none;
                transition: border-color 0.18s;
            }

            .auth-input:focus { border-color: #4f46e5; }

            .auth-input-icon {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                color: #9ca3af;
                cursor: pointer;
                background: none;
                border: none;
                padding: 0;
                display: flex;
                align-items: center;
            }

            .auth-field { margin-bottom: 16px; }

            .auth-error {
                color: #dc2626;
                font-size: 0.8125rem;
                margin-top: 4px;
                display: block;
            }

            .auth-btn {
                width: 100%;
                padding: 13px;
                background: #2563eb;
                border: none;
                border-radius: 8px;
                font-size: 0.9375rem;
                font-weight: 600;
                font-family: 'Inter', sans-serif;
                color: #fff;
                cursor: pointer;
                margin-top: 6px;
                transition: background 0.18s;
            }

            .auth-btn:hover { background: #1d4ed8; }

            .auth-divider {
                display: flex;
                align-items: center;
                gap: 12px;
                margin: 18px 0;
                font-size: 0.8125rem;
                color: #9ca3af;
            }

            .auth-divider::before,
            .auth-divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background: #e5e7eb;
            }

            .auth-social {
                display: flex;
                gap: 10px;
                margin-bottom: 20px;
            }

            .auth-social-btn {
                flex: 1;
                padding: 9px 8px;
                background: #fff;
                border: 1.5px solid #e5e7eb;
                border-radius: 8px;
                font-size: 0.8125rem;
                font-weight: 500;
                font-family: 'Inter', sans-serif;
                color: #374151;
                cursor: pointer;
                text-align: center;
                transition: border-color 0.18s;
            }

            .auth-social-btn:hover { border-color: #4f46e5; color: #4f46e5; }

            .auth-footer {
                text-align: center;
                font-size: 0.875rem;
                color: #6b7280;
            }

            .auth-footer a {
                font-weight: 600;
                color: #4f46e5;
                text-decoration: none;
            }

            .auth-footer a:hover { color: #4338ca; }

            .auth-forgot {
                font-size: 0.8125rem;
                color: #6b7280;
                text-decoration: none;
                display: block;
                margin-top: 6px;
            }

            .auth-forgot:hover { color: #4f46e5; }

            @media (max-width: 680px) {
                .auth-card { flex-direction: column; }
                .auth-panel { flex: none; min-height: 180px; margin: 8px; }
                .auth-form-side { padding: 28px 24px; }
            }
        </style>
    </head>
    <body>
        <div class="auth-card">
            <div class="auth-panel">
                <div class="panel-star">KursusKu</div>
                <div>
                    <p class="panel-tagline-sm">Kamu bisa dengan mudah</p>
                    <h2 class="panel-heading">Tingkatkan skill bersama mentor terbaik, kapan saja dan di mana saja</h2>
                </div>
            </div>
            <div class="auth-form-side">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
