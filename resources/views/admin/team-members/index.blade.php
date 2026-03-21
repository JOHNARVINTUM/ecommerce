@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Team Members</h1>
            <a href="{{ route('admin.team-members.create') }}" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Add Provider
            </a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach ($teamMembers as $member)
                        <tr>
                            <td class="px-4 py-3 text-sm text-white">{{ $member->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $member->email }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $member->role === 'admin' ? 'bg-sky-500/20 text-sky-300' : 'bg-indigo-500/20 text-indigo-300' }}">
                                    {{ ucfirst($member->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.team-members.edit', $member) }}" class="font-semibold text-indigo-300 hover:text-indigo-200">
                                        Edit
                                    </a>
                                    @if ($member->role !== 'admin')
                                        <form method="POST" action="{{ route('admin.team-members.destroy', $member) }}" onsubmit="return confirm('Delete this team member?');">
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
            {{ $teamMembers->links() }}
        </div>
    </div>
@endsection
