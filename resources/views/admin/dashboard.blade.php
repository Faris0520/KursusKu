<x-panel-layout>
    <div class="panel-page-header">
        <h1 class="panel-page-title">Dashboard</h1>
    </div>

    <div class="panel-card">
        <div class="panel-card-body" style="text-align:center;padding:48px 24px;">
            <p style="font-size:1.125rem;font-weight:600;color:#111827;margin-bottom:8px;">
                Selamat datang, {{ auth()->user()->name }}!
            </p>
            <p style="font-size:0.875rem;color:#6b7280;">Kamu sudah berhasil login.</p>
        </div>
    </div>
</x-panel-layout>