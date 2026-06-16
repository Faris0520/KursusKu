<x-panel-layout>

<div class="panel-page-header">
    <div>
        <p class="panel-breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Pengguna</p>
        <h1 class="panel-page-title">Kelola Pengguna</h1>
    </div>
</div>

{{-- Filter --}}
<div class="panel-card" style="margin-bottom:20px;">
    <div class="panel-card-body" style="padding:16px 20px;">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau email..."
                class="panel-form-input"
                style="flex:1;min-width:200px;"
            >
            <select name="role" class="panel-form-select" style="width:160px;">
                <option value="">Semua Role</option>
                <option value="siswa"   @selected(request('role') == 'siswa')>Siswa</option>
                <option value="mentor"  @selected(request('role') == 'mentor')>Mentor</option>
                <option value="admin"   @selected(request('role') == 'admin')>Admin</option>
            </select>
            <button type="submit" class="btn-register btn-sm" style="height:36px;padding:0 18px;font-size:0.8125rem;">Filter</button>
            @if(request()->hasAny(['search','role']))
                <a href="{{ route('admin.users.index') }}" class="btn-outline btn-sm" style="height:36px;line-height:36px;padding:0 14px;">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="panel-card">
    <div class="panel-card-header">
        <span class="panel-card-title">Daftar Pengguna</span>
        <span style="font-size:0.8125rem;color:#9ca3af;">{{ $users->total() }} pengguna</span>
    </div>
    <table class="panel-table">
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Email</th>
                <th>Role</th>
                <th>Bergabung</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:32px;height:32px;border-radius:50%;background:#e0e7ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.75rem;font-weight:700;color:#2563eb;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span style="font-weight:500;color:#111827;">{{ $user->name }}</span>
                    </div>
                </td>
                <td style="color:#6b7280;font-size:0.8125rem;">{{ $user->email }}</td>
                <td>
                    @php $roleColor = ['admin'=>'#dc2626','mentor'=>'#7c3aed','siswa'=>'#2563eb'][$user->role] ?? '#6b7280'; @endphp
                    <span style="background:{{ $roleColor }}1a;color:{{ $roleColor }};font-size:0.75rem;font-weight:600;padding:3px 10px;border-radius:999px;text-transform:capitalize;">
                        {{ $user->role }}
                    </span>
                </td>
                <td style="color:#9ca3af;font-size:0.8125rem;">{{ $user->created_at->timezone('Asia/Jakarta')->format('d M Y') }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                            @csrf @method('PATCH')
                            <select name="role" onchange="this.form.submit()" class="panel-form-select" style="width:auto;padding:5px 10px;font-size:0.8125rem;">
                                <option value="siswa"  @selected($user->role == 'siswa')>Siswa</option>
                                <option value="mentor" @selected($user->role == 'mentor')>Mentor</option>
                                <option value="admin"  @selected($user->role == 'admin')>Admin</option>
                            </select>
                        </form>
                        @if(auth()->id() !== $user->id)
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin hapus pengguna {{ addslashes($user->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger btn-sm">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="panel-empty">Tidak ada pengguna yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($users->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #f3f4f6;">
        {{ $users->withQueryString()->links() }}
    </div>
    @endif
</div>

</x-panel-layout>
