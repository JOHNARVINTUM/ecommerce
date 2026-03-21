@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-2xl font-bold text-white">Users</h1>
            <a href="{{ route('admin.users.create') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-[#111] transition hover:bg-white/90">
                Add User
            </a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Created</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-sm text-white">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $user->role === 'admin' ? 'bg-sky-500/20 text-sky-300' : ($user->role === 'provider' ? 'bg-indigo-500/20 text-indigo-300' : 'bg-emerald-500/20 text-emerald-300') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $user->created_at?->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.users.show', $user) }}" class="font-semibold text-indigo-300 hover:text-indigo-200">
                                        View
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="font-semibold text-sky-300 hover:text-sky-200">
                                        Edit
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-semibold text-rose-300 hover:text-rose-200">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
@endsection
