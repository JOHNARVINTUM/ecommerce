<footer class="bg-[#ecece9] px-6 py-12 sm:px-10 lg:px-12">
    <div class="grid gap-10 text-sm text-[#2f2f2f] md:grid-cols-5">
        <div class="md:col-span-2">
            <p class="text-[2rem] font-black uppercase leading-none tracking-[-0.08em] text-[#141414]">LIMAX</p>
            <p class="mt-4 max-w-2xl text-[15px] leading-8 text-[#6b6b6b]">
                LIMAX is a technology-focused freelancing platform built for businesses and creators who need reliable IT expertise.
                We connect clients with skilled professionals in programming, web design, graphic design, video editing, and other
                digital services. Every project is handled with quality, transparency, and care so you can focus on your goals while
                we connect you with the right talent.
            </p>

            <div class="mt-8 flex items-center gap-4 text-[#8a8a8a]">
                <a href="#" aria-label="Instagram" class="transition hover:text-black">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3.5" y="3.5" width="17" height="17" rx="4"></rect>
                        <circle cx="12" cy="12" r="4"></circle>
                        <circle cx="17.5" cy="6.5" r="1"></circle>
                    </svg>
                </a>
                <a href="#" aria-label="LinkedIn" class="transition hover:text-black">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M5.5 8.5A1.5 1.5 0 1 0 5.5 5.5a1.5 1.5 0 0 0 0 3ZM4 10h3v10H4V10Zm5 0h2.9v1.4h.1c.4-.8 1.4-1.7 2.9-1.7 3.1 0 3.6 2 3.6 4.7V20h-3v-4.9c0-1.2 0-2.7-1.7-2.7s-1.9 1.3-1.9 2.6V20H9V10Z"></path>
                    </svg>
                </a>
                <a href="#" aria-label="X" class="transition hover:text-black">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.9 3H22l-6.8 7.8L23 21h-6.1l-4.8-6.2L6.7 21H3.6l7.2-8.2L1 3h6.3l4.3 5.7L18.9 3Zm-1.1 16h1.7L6.4 4.9H4.6L17.8 19Z"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div>
            <p class="text-lg font-semibold text-[#141414]">Features</p>
            <ul class="mt-4 space-y-3 text-[15px] text-[#6b6b6b]">
                <li><a href="{{ route('services.index') }}" class="hover:text-black">Core features</a></li>
                <li><a href="{{ route('services.index') }}" class="hover:text-black">Pro experience</a></li>
                <li><a href="{{ route('services.index') }}" class="hover:text-black">Integrations</a></li>
            </ul>
        </div>

        <div>
            <p class="text-lg font-semibold text-[#141414]">Learn more</p>
            <ul class="mt-4 space-y-3 text-[15px] text-[#6b6b6b]">
                <li><a href="{{ route('about') }}" class="hover:text-black">Blog</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-black">Case studies</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-black">Customer stories</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-black">Best practices</a></li>
            </ul>
        </div>

        <div>
            <p class="text-lg font-semibold text-[#141414]">Support</p>
            <ul class="mt-4 space-y-3 text-[15px] text-[#6b6b6b]">
                <li><a href="{{ route('about') }}" class="hover:text-black">Contact</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-black">Support</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-black">Legal</a></li>
            </ul>
        </div>
    </div>
</footer>
