@extends($user->role === 'provider' ? 'layouts.provider' : 'layouts.guest')

@php
    $profile = $user->profile;
    $settings = $user->settings;
    $initials = collect(explode(' ', $user->name))->filter()->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
    $startInEditMode = $errors->any();
@endphp

@section('content')
    <style>
        .profile-input[disabled] {
            opacity: 0.9;
            cursor: default;
        }
        .profile-panel {
            transition: box-shadow .3s ease, border-color .3s ease, transform .3s ease;
        }
        .profile-panel.is-editing {
            border-color: rgba(167, 139, 250, 0.55);
            box-shadow: 0 24px 46px rgba(76, 29, 149, 0.18);
            transform: translateY(-2px);
        }
        .profile-edit-actions {
            transition: opacity .22s ease, transform .22s ease;
        }
        .profile-edit-actions.hidden {
            opacity: 0;
            transform: translateY(8px);
            pointer-events: none;
            display: flex;
        }
        .profile-edit-actions:not(.hidden) {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    @if ($user->role === 'provider')
        <div class="space-y-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.26em] text-white/45">Provider Workspace</p>
                    <h1 class="mt-2 text-3xl font-bold text-white">Profile</h1>
                    <p class="mt-2 text-white/65">Manage your provider account details and contact information.</p>
                </div>
                <a href="{{ route('provider.orders.index') }}" class="rounded-xl border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
                    Go to Orders
                </a>
            </div>

            <div class="profile-panel rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)] sm:p-8" id="profile-panel">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-indigo-500/70 text-lg font-bold text-white">
                            {{ $initials }}
                        </div>
                        <div>
                            <p class="text-2xl font-semibold text-white">{{ $user->name }}</p>
                            <p class="text-base text-white/55">{{ $user->email }}</p>
                        </div>
                    </div>

                    <button
                        type="button"
                        id="profile-edit-toggle"
                        class="rounded-xl border border-white/20 bg-white/5 px-5 py-2 text-sm font-semibold text-white transition hover:border-white/35 hover:bg-white/10"
                    >
                        Edit Profile
                    </button>
                </div>

                @if (session('status') === 'profile-updated')
                    <div class="mt-5 rounded-xl border border-emerald-400/30 bg-emerald-500/15 px-4 py-3 text-sm text-emerald-200">
                        Profile updated successfully.
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="mt-6" id="profile-edit-form" data-start-in-edit="{{ $startInEditMode ? '1' : '0' }}">
                    @csrf
                    @method('PATCH')

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="name" class="mb-2 block text-sm font-semibold uppercase tracking-wider text-white/65">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" data-initial-value="{{ old('name', $user->name) }}" class="profile-input w-full rounded-xl border border-white/15 bg-white/[0.03] px-4 py-3 text-base text-white placeholder:text-white/45 transition focus:border-white/35 focus:outline-none" required {{ $startInEditMode ? '' : 'disabled' }}>
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm" />
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold uppercase tracking-wider text-white/65">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" data-initial-value="{{ old('email', $user->email) }}" class="profile-input w-full rounded-xl border border-white/15 bg-white/[0.03] px-4 py-3 text-base text-white placeholder:text-white/45 transition focus:border-white/35 focus:outline-none" required {{ $startInEditMode ? '' : 'disabled' }}>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
                        </div>

                        <div>
                            <label for="phone" class="mb-2 block text-sm font-semibold uppercase tracking-wider text-white/65">Mobile Number</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone', $profile?->phone) }}" data-initial-value="{{ old('phone', $profile?->phone) }}" placeholder="Add number" class="profile-input w-full rounded-xl border border-white/15 bg-white/[0.03] px-4 py-3 text-base text-white placeholder:text-white/45 transition focus:border-white/35 focus:outline-none" {{ $startInEditMode ? '' : 'disabled' }}>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm" />
                        </div>

                        <div>
                            <label for="location" class="mb-2 block text-sm font-semibold uppercase tracking-wider text-white/65">Address</label>
                            <input id="location" name="location" type="text" value="{{ old('location', $profile?->location) }}" data-initial-value="{{ old('location', $profile?->location) }}" placeholder="Add address" class="profile-input w-full rounded-xl border border-white/15 bg-white/[0.03] px-4 py-3 text-base text-white placeholder:text-white/45 transition focus:border-white/35 focus:outline-none" {{ $startInEditMode ? '' : 'disabled' }}>
                            <x-input-error :messages="$errors->get('location')" class="mt-2 text-sm" />
                        </div>
                    </div>

                    <div class="profile-edit-actions mt-8 flex flex-wrap items-center gap-3 {{ $startInEditMode ? '' : 'hidden' }}" id="profile-edit-actions">
                        <button type="submit" class="rounded-xl bg-white px-6 py-3 text-sm font-semibold text-[#111] transition hover:bg-white/90">
                            Save Changes
                        </button>
                        <button type="button" id="profile-edit-cancel" class="rounded-xl border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition hover:border-white/35 hover:bg-white/10">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
    <div class="min-h-screen w-full overflow-x-clip bg-[#0d0e13] text-white">
        <header class="sticky top-0 z-40 border-b border-white/5 bg-[#0d0e13]/90 backdrop-blur-md">
            <div class="flex w-full items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('user.home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                    LIMAX
                </a>

                <nav class="flex items-center gap-3 text-[11px] text-white/85 sm:gap-8 sm:text-sm">
                    <a href="{{ route('services.index') }}" class="transition hover:text-white">Services</a>
                    <a href="{{ route('about') }}" class="transition hover:text-white">About Us</a>
                    @auth
                        <a href="{{ route('cart.index') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-white/75">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </a>
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                            <button @click="open = ! open" class="flex items-center gap-2 rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg"
                                    style="display: none;"
                                    @click="open = false">
                                <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white py-1">
                                    <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100">
                                        My Profile
                                    </a>
                                    <a href="{{ route('orders.index') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100">
                                        My Orders
                                    </a>
                                    <a href="{{ route('cart.index') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100">
                                        My Cart
                                    </a>
                                    <hr class="my-1 border-gray-200">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100">
                                            Log out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-white/75">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">USER</a>
                    @endauth
                </nav>
            </div>
        </header>

        <section class="mx-auto w-full max-w-[1440px] px-5 py-10 sm:px-8 lg:px-10">
            <div class="max-w-4xl mx-auto">
                <div class="profile-panel rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)] sm:p-8" id="profile-panel">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-violet-500/70 text-lg font-bold text-white">
                                {{ $initials }}
                            </div>
                            <div>
                                <p class="text-2xl font-semibold text-white">{{ $user->name }}</p>
                                <p class="text-base text-white/55">{{ $user->email }}</p>
                            </div>
                        </div>

                        <button
                            type="button"
                            id="profile-edit-toggle"
                            class="rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold text-white transition hover:border-white/35 hover:bg-white/15"
                        >
                            Edit Profile
                        </button>
                    </div>

                    @if (session('status') === 'profile-updated')
                        <div class="mt-5 rounded-xl border border-emerald-400/30 bg-emerald-500/15 px-4 py-3 text-sm text-emerald-200">
                            Profile updated successfully.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" class="mt-6" id="profile-edit-form" data-start-in-edit="{{ $startInEditMode ? '1' : '0' }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-2 border-t border-white/10 pt-5">
                            <div class="grid gap-3 py-4 md:grid-cols-[180px_minmax(0,1fr)] md:items-center">
                                <label for="name" class="text-xl font-medium">Name</label>
                                <div>
                                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" data-initial-value="{{ old('name', $user->name) }}" class="profile-input w-full rounded-lg border border-transparent bg-transparent px-3 py-2 text-right text-xl text-white/70 transition focus:border-white/25 focus:bg-white/[0.04] focus:outline-none md:text-right" required {{ $startInEditMode ? '' : 'disabled' }}>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm" />
                                </div>
                            </div>

                            <div class="border-t border-white/10"></div>

                            <div class="grid gap-3 py-4 md:grid-cols-[180px_minmax(0,1fr)] md:items-center">
                                <label for="email" class="text-xl font-medium">Email account</label>
                                <div>
                                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" data-initial-value="{{ old('email', $user->email) }}" class="profile-input w-full rounded-lg border border-transparent bg-transparent px-3 py-2 text-right text-xl text-white/70 transition focus:border-white/25 focus:bg-white/[0.04] focus:outline-none md:text-right" required {{ $startInEditMode ? '' : 'disabled' }}>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
                                </div>
                            </div>

                            <div class="border-t border-white/10"></div>

                            <div class="grid gap-3 py-4 md:grid-cols-[180px_minmax(0,1fr)] md:items-center">
                                <label for="phone" class="text-xl font-medium">Mobile number</label>
                                <div>
                                    <input id="phone" name="phone" type="text" value="{{ old('phone', $profile?->phone) }}" data-initial-value="{{ old('phone', $profile?->phone) }}" placeholder="Add number" class="profile-input w-full rounded-lg border border-transparent bg-transparent px-3 py-2 text-right text-xl text-white/70 placeholder:text-white/40 transition focus:border-white/25 focus:bg-white/[0.04] focus:outline-none md:text-right" {{ $startInEditMode ? '' : 'disabled' }}>
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm" />
                                </div>
                            </div>

                            <div class="border-t border-white/10"></div>

                            <div class="grid gap-3 py-4 md:grid-cols-[180px_minmax(0,1fr)] md:items-center">
                                <label for="location" class="text-xl font-medium">Address</label>
                                <div>
                                    <input id="location" name="location" type="text" value="{{ old('location', $profile?->location) }}" data-initial-value="{{ old('location', $profile?->location) }}" placeholder="Add address" class="profile-input w-full rounded-lg border border-transparent bg-transparent px-3 py-2 text-right text-xl text-white/70 placeholder:text-white/40 transition focus:border-white/25 focus:bg-white/[0.04] focus:outline-none md:text-right" {{ $startInEditMode ? '' : 'disabled' }}>
                                    <x-input-error :messages="$errors->get('location')" class="mt-2 text-sm" />
                                </div>
                            </div>
                        </div>

                        <div class="profile-edit-actions mt-8 flex flex-wrap items-center gap-3 {{ $startInEditMode ? '' : 'hidden' }}" id="profile-edit-actions">
                            <button type="submit" class="rounded-full bg-white px-6 py-3 text-base font-semibold text-black transition hover:bg-white/90">
                                Save Change
                            </button>
                            <button type="button" id="profile-edit-cancel" class="rounded-full border border-white/20 bg-white/10 px-6 py-3 text-base font-semibold text-white transition hover:border-white/35 hover:bg-white/15">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <x-auth-footer />
    </div>
    @endif

    <script>
        (() => {
            const form = document.getElementById('profile-edit-form');
            const toggleButton = document.getElementById('profile-edit-toggle');
            const actions = document.getElementById('profile-edit-actions');
            const cancelButton = document.getElementById('profile-edit-cancel');
            const panel = document.getElementById('profile-panel');

            if (!form || !toggleButton || !actions || !cancelButton || !panel) {
                return;
            }

            const inputs = Array.from(form.querySelectorAll('.profile-input'));
            let isEditing = form.dataset.startInEdit === '1';

            const setEditing = (editing) => {
                isEditing = editing;
                inputs.forEach((input) => {
                    input.disabled = !editing;
                });

                actions.classList.toggle('hidden', !editing);
                toggleButton.classList.toggle('hidden', editing);
                panel.classList.toggle('is-editing', editing);
            };

            toggleButton.addEventListener('click', () => {
                setEditing(true);
                const firstInput = inputs[0];
                if (firstInput) {
                    firstInput.focus();
                }
            });

            cancelButton.addEventListener('click', () => {
                inputs.forEach((input) => {
                    input.value = input.dataset.initialValue || '';
                });
                setEditing(false);
            });

            setEditing(isEditing);
        })();
    </script>
@endsection
