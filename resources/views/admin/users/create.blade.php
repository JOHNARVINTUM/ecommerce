@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-3xl rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Create User</h1>
                <p class="mt-1 text-sm text-white/65">Add a new account with admin-level control over role and profile basics.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
                Back
            </a>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-white/85">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('name') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-white/85">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('email') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="role" class="mb-2 block text-sm font-medium text-white/85">Role</label>
                    <select name="role" id="role" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                        @foreach (['customer' => 'Customer', 'provider' => 'Provider', 'admin' => 'Admin'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('role', 'customer') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-white/85">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('phone') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-white/85">Password</label>
                    <input type="password" name="password" id="password" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('password') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-white/85">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                </div>
            </div>

            <div>
                <label for="location" class="mb-2 block text-sm font-medium text-white/85">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                @error('location') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="bio" class="mb-2 block text-sm font-medium text-white/85">Bio</label>
                <textarea name="bio" id="bio" rows="4" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">{{ old('bio') }}</textarea>
                @error('bio') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#111] transition hover:bg-white/90">
                Create User
            </button>
        </form>
    </div>
@endsection
