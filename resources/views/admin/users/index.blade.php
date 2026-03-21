@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Users</h1>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-sm text-slate-800">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ ucfirst($user->role) }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">
                                <a href="{{ route('admin.users.show', $user) }}" class="font-semibold text-indigo-600 hover:text-indigo-800">
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
