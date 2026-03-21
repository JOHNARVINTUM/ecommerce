@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Edit Team Member</h1>
                <p class="mt-1 text-sm text-white/65">Update account and profile details.</p>
            </div>
            <a href="{{ route('admin.team-members.index') }}" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
                Back
            </a>
        </div>

        <form action="{{ route('admin.team-members.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-white/85">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('name') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-white/85">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('email') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-white/85">New Password (optional)</label>
                    <input type="password" name="password" id="password" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('password') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-white/85">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-white/85">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->profile->phone ?? '') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('phone') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="location" class="mb-2 block text-sm font-medium text-white/85">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $user->profile->location ?? '') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('location') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="display_name" class="mb-2 block text-sm font-medium text-white/85">Display Name</label>
                    <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $user->providerProfile->display_name ?? $user->name) }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('display_name') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="headline" class="mb-2 block text-sm font-medium text-white/85">Headline</label>
                    <input type="text" name="headline" id="headline" value="{{ old('headline', $user->providerProfile->headline ?? '') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('headline') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="country" class="mb-2 block text-sm font-medium text-white/85">Country</label>
                    <input type="text" name="country" id="country" value="{{ old('country', $user->providerProfile->country ?? '') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('country') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="languages" class="mb-2 block text-sm font-medium text-white/85">Languages</label>
                    <input type="text" name="languages" id="languages" value="{{ old('languages', $user->providerProfile->languages ?? '') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('languages') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="response_time" class="mb-2 block text-sm font-medium text-white/85">Response Time</label>
                    <input type="text" name="response_time" id="response_time" value="{{ old('response_time', $user->providerProfile->response_time ?? '') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('response_time') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="github_url" class="mb-2 block text-sm font-medium text-white/85">GitHub URL (optional)</label>
                    <input type="url" name="github_url" id="github_url" value="{{ old('github_url', $user->providerProfile->github_url ?? '') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('github_url') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="bio" class="mb-2 block text-sm font-medium text-white/85">Bio</label>
                <textarea name="bio" id="bio" rows="4" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">{{ old('bio', $user->profile->bio ?? $user->providerProfile->bio ?? '') }}</textarea>
                @error('bio') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Save Changes
            </button>
        </form>
    </div>
@endsection
