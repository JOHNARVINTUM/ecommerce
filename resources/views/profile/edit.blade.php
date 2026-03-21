@extends('layouts.guest')

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

    <div class="min-h-screen w-full overflow-x-hidden bg-[#0d0e13] text-white">
        <header class="sticky top-0 z-40 border-b border-white/5 bg-[#0d0e13]/90 backdrop-blur-md">
            <div class="flex w-full items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('user.home') }}" class="text-3xl font-black uppercase leading-none tracking-[-0.08em] text-white sm:text-4xl">
                    LIMAX
                </a>

                <nav class="flex items-center gap-3 text-[11px] text-white/85 sm:gap-8 sm:text-sm">
                    <a href="{{ route('services.index') }}" class="transition hover:text-white">Services</a>
                    <a href="{{ route('about') }}" class="transition hover:text-white">About Us</a>
                    <a href="{{ route('orders.index') }}" aria-label="Cart" class="inline-flex items-center justify-center text-white transition hover:text-white/75">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                            <path d="M6 7.5C6 4.74 8.24 2.5 11 2.5C13.76 2.5 16 4.74 16 7.5V9H18.5C19.05 9 19.5 9.45 19.5 10V19.5C19.5 20.6 18.6 21.5 17.5 21.5H4.5C3.4 21.5 2.5 20.6 2.5 19.5V10C2.5 9.45 2.95 9 3.5 9H6V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8.5 9V7.5C8.5 6.12 9.62 5 11 5C12.38 5 13.5 6.12 13.5 7.5V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-black transition hover:bg-white/90">Log out</button>
                    </form>
                </nav>
            </div>
        </header>

        <section class="mx-auto w-full max-w-[1440px] px-5 py-10 sm:px-8 lg:px-10">
            <div class="grid gap-8 xl:grid-cols-[300px_minmax(0,1fr)]">
                <div class="space-y-8">
                    <aside class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-violet-500/70 text-lg font-bold text-white">
                                {{ $initials }}
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-white">{{ $user->name }}</p>
                                <p class="text-sm text-white/55">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="mt-5 border-t border-white/10 pt-4">
                            <div class="flex items-center justify-between rounded-xl bg-white/10 px-4 py-3">
                                <span class="font-medium">My Profile</span>
                                <span class="text-white/50">></span>
                            </div>
                            <div class="mt-3 flex items-center justify-between px-4 py-3">
                                <span class="font-medium">Notification</span>
                                <span class="text-sm text-white/55">{{ $settings?->notifications_enabled ? 'Allow' : 'Off' }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="flex w-full items-center justify-between px-4 py-3 text-left font-medium transition hover:text-white/75">
                                    <span>Log Out</span>
                                    <span class="text-white/50">></span>
                                </button>
                            </form>
                        </div>
                    </aside>
                </div>

                <section class="profile-panel rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)] sm:p-8" id="profile-panel">
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
                                <label for="location" class="text-xl font-medium">Location</label>
                                <div>
                                    <input id="location" name="location" type="text" value="{{ old('location', $profile?->location) }}" data-initial-value="{{ old('location', $profile?->location) }}" placeholder="Add location" class="profile-input w-full rounded-lg border border-transparent bg-transparent px-3 py-2 text-right text-xl text-white/70 placeholder:text-white/40 transition focus:border-white/25 focus:bg-white/[0.04] focus:outline-none md:text-right" {{ $startInEditMode ? '' : 'disabled' }}>
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
                </section>
            </div>
        </section>

        <x-auth-footer />
    </div>

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
