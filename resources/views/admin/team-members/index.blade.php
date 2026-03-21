@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">Team Members</h1>
            <a href="{{ route('admin.team-members.create') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                Add Provider
            </a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Role</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($teamMembers as $member)
                        <tr>
                            <td class="px-4 py-3 text-sm text-slate-800">{{ $member->name }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $member->email }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ ucfirst($member->role) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $teamMembers->links() }}
        </div>
    </div>
@endsection
