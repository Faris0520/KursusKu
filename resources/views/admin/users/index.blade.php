<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Kelola User</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search -->
            <form method="GET" class="mb-6 flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="rounded-md border-gray-300 flex-1">
                <select name="role" class="rounded-md border-gray-300">
                    <option value="">Semua Role</option>
                    <option value="siswa"@selected(request('role')=='siswa')>Siswa</option>
                    <option value="mentor"@selected(request('role')=='mentor')>Mentor</option>
                    <option value="admin"@selected(request('role')=='admin')>Admin</option>
                </select>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Filter</button>
            </form>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $user->role === 'mentor' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $user->role === 'siswa' ? 'bg-green-100 text-green-800' : '' }}
                                ">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                                    @csrf @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" class="text-sm rounded border-gray-300">
                                        <option value="siswa"@selected($user->role == 'siswa')>Siswa</option>
                                        <option value="mentor"@selected($user->role == 'mentor')>Mentor</option>
                                        <option value="admin"@selected($user->role == 'admin')>Admin</option>
                                    </select>
                                </form>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 text-sm hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>