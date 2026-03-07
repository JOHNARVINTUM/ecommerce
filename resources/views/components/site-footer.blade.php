<footer class="border-t border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-4">
            <div class="md:col-span-2">
                <h2 class="text-xl font-bold text-slate-900">LIMAX</h2>
                <p class="mt-3 max-w-md text-sm leading-6 text-slate-600">
                    A digital services marketplace where customers discover trusted providers for design, development,
                    editing, and creative work.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-900">Company</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li><a href="{{ route('about') }}" class="hover:text-slate-900">About</a></li>
                    <li><a href="#" class="hover:text-slate-900">Services</a></li>
                    <li><a href="#" class="hover:text-slate-900">Support</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-900">Legal</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li><a href="#" class="hover:text-slate-900">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-slate-900">Terms of Service</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t border-slate-200 pt-6 text-sm text-slate-500">
            © {{ date('Y') }} LIMAX. All rights reserved.
        </div>
    </div>
</footer>