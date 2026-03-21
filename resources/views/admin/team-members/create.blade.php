@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Add Provider Account</h1>
                <p class="mt-1 text-sm text-slate-600">Create a new provider under Team Members.</p>
            </div>
            <a href="{{ route('admin.team-members.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Back to Team Members
            </a>
        </div>

        <form action="{{ route('admin.team-members.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('email') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('password') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-slate-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('phone') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="location" class="mb-2 block text-sm font-medium text-slate-700">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('location') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="display_name" class="mb-2 block text-sm font-medium text-slate-700">Display Name</label>
                    <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('display_name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="headline" class="mb-2 block text-sm font-medium text-slate-700">Headline</label>
                    <input type="text" name="headline" id="headline" value="{{ old('headline') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('headline') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="country" class="mb-2 block text-sm font-medium text-slate-700">Country</label>
                    <input type="text" name="country" id="country" value="{{ old('country') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('country') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="languages" class="mb-2 block text-sm font-medium text-slate-700">Languages</label>
                    <input type="text" name="languages" id="languages" value="{{ old('languages') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('languages') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="response_time" class="mb-2 block text-sm font-medium text-slate-700">Response Time</label>
                    <input type="text" name="response_time" id="response_time" value="{{ old('response_time') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('response_time') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="github_url" class="mb-2 block text-sm font-medium text-slate-700">GitHub URL (optional)</label>
                    <input type="url" name="github_url" id="github_url" value="{{ old('github_url') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('github_url') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="bio" class="mb-2 block text-sm font-medium text-slate-700">Bio</label>
                <textarea name="bio" id="bio" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('bio') }}</textarea>
                @error('bio') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                Create Provider Account
            </button>
        </form>
    </div>
@endsection
