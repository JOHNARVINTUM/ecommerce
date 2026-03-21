@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <h1 class="text-2xl font-bold text-white">Users</h1>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-sm text-white">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ ucfirst($user->role) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('admin.users.show', $user) }}" class="font-semibold text-indigo-300 hover:text-indigo-200">
                                    View More
                                </a>
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
