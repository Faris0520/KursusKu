<x-panel-layout>
    <h1 class="panel-page-title" style="margin-bottom:24px;">Profil Saya</h1>

    <div style="max-width:680px;display:flex;flex-direction:column;gap:20px;">
        <div class="panel-card">
            <div class="panel-card-header">
                <span class="panel-card-title">Informasi Profil</span>
            </div>
            <div class="panel-card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card-header">
                <span class="panel-card-title">Ubah Password</span>
            </div>
            <div class="panel-card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card-header">
                <span class="panel-card-title" style="color:#dc2626;">Hapus Akun</span>
            </div>
            <div class="panel-card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-panel-layout>