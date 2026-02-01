<div>
    <div class="absolute left-1/2 top-1/2 w-full -translate-x-1/2 -translate-y-1/2 p-3">
        <div class="bg-base-100/60 card relative z-10 mx-auto w-full max-w-md border border-slate-200 backdrop-blur-lg">
            <div class="card-body items-center text-center">
                <!-- Animated Success SVG -->
                <div class="relative mb-6">
                    <!-- Outer glow ring -->
                    <div class="absolute inset-0 animate-ping rounded-full bg-emerald-400/30"></div>

                    <!-- Main SVG -->
                    <svg class="relative h-32 w-32" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Background circle with gradient -->
                        <defs>
                            <linearGradient
                                id="successGradient"
                                x1="0%"
                                y1="0%"
                                x2="100%"
                                y2="100%"
                            >
                                <stop style="stop-color:#10b981;stop-opacity:1" offset="0%" />
                                <stop style="stop-color:#059669;stop-opacity:1" offset="50%" />
                                <stop style="stop-color:#047857;stop-opacity:1" offset="100%" />
                            </linearGradient>
                            <linearGradient
                                id="shineGradient"
                                x1="0%"
                                y1="0%"
                                x2="100%"
                                y2="100%"
                            >
                                <stop style="stop-color:#ffffff;stop-opacity:0.3" offset="0%" />
                                <stop style="stop-color:#ffffff;stop-opacity:0" offset="50%" />
                                <stop style="stop-color:#ffffff;stop-opacity:0.1" offset="100%" />
                            </linearGradient>
                            <filter id="glow">
                                <feGaussianBlur stdDeviation="3" result="coloredBlur" />
                                <feMerge>
                                    <feMergeNode in="coloredBlur" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>
                        </defs>

                        <!-- Outer decorative ring -->
                        <circle
                            cx="64"
                            cy="64"
                            r="60"
                            stroke="url(#successGradient)"
                            stroke-width="2"
                            fill="none"
                            opacity="0.3"
                        />

                        <!-- Main circle -->
                        <circle
                            cx="64"
                            cy="64"
                            r="52"
                            fill="url(#successGradient)"
                            filter="url(#glow)"
                        />

                        <!-- Shine effect -->
                        <circle cx="64" cy="64" r="52" fill="url(#shineGradient)" />

                        <!-- Checkmark with animation -->
                        <path
                            class="animate-[draw_0.6s_ease-out_0.3s_forwards]"
                            style="stroke-dasharray: 80; stroke-dashoffset: 0;"
                            d="M40 65L56 81L88 49"
                            stroke="white"
                            stroke-width="8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            fill="none"
                        />

                        <!-- Decorative sparkles -->
                        <circle
                            cx="20"
                            cy="40"
                            r="3"
                            fill="#10b981"
                            opacity="0.6"
                        >
                            <animate
                                values="0.6;1;0.6"
                                values="0.6;1;0.6"
                                attributeName="opacity"
                                dur="2s"
                                repeatCount="indefinite"
                            />
                        </circle>
                        <circle
                            cx="108"
                            cy="35"
                            r="2"
                            fill="#34d399"
                            opacity="0.8"
                        >
                            <animate
                                values="0.8;0.3;0.8"
                                values="0.8;0.3;0.8"
                                attributeName="opacity"
                                dur="1.5s"
                                repeatCount="indefinite"
                            />
                        </circle>
                        <circle
                            cx="100"
                            cy="95"
                            r="2.5"
                            fill="#6ee7b7"
                            opacity="0.7"
                        >
                            <animate
                                values="0.7;1;0.7"
                                values="0.7;1;0.7"
                                attributeName="opacity"
                                dur="1.8s"
                                repeatCount="indefinite"
                            />
                        </circle>
                        <circle
                            cx="25"
                            cy="90"
                            r="2"
                            fill="#a7f3d0"
                            opacity="0.6"
                        >
                            <animate
                                values="0.6;0.9;0.6"
                                values="0.6;0.9;0.6"
                                attributeName="opacity"
                                dur="2.2s"
                                repeatCount="indefinite"
                            />
                        </circle>

                        <!-- Email icon overlay -->
                        <g transform="translate(44, 85) scale(0.4)">
                            <rect
                                x="0"
                                y="10"
                                width="48"
                                height="32"
                                rx="4"
                                fill="white"
                                opacity="0.9"
                            />
                            <path d="M0 14L24 28L48 14" stroke="#059669" stroke-width="3" fill="none" />
                        </g>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="mb-2 text-2xl font-bold text-slate-800">
                    Email Terverifikasi!
                </h1>

                <!-- Description -->
                <p class="mb-6 text-slate-600">
                    Selamat! Email Anda telah berhasil diverifikasi.
                    Sekarang Anda dapat mengakses semua fitur aplikasi.
                </p>

                <!-- Decorative divider -->
                <div class="mb-6 flex w-full items-center gap-3">
                    <div class="h-px flex-1 bg-gradient-to-r from-transparent via-emerald-300 to-transparent"></div>
                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <div class="h-px flex-1 bg-gradient-to-r from-transparent via-emerald-300 to-transparent"></div>
                </div>

                <!-- Action button -->
                <a class="btn btn-primary btn-block gap-2" href="{{ route('dashboard') }}" wire:navigate>
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />
                    </svg>
                    Lanjut ke Dashboard
                </a>

                <!-- Secondary link -->
                <a class="btn btn-ghost btn-sm mt-2 text-slate-500" href="{{ route('account') }}" wire:navigate>
                    Ke Halaman Akun Saya
                </a>
            </div>
        </div>

        <!-- Background gradient blur -->
        <div
            class='z-1 pointer-events-none absolute bottom-0 left-0 right-0 h-[60vh] w-full bg-gradient-to-br from-emerald-200 via-teal-500 to-cyan-300 opacity-30 blur-[200px]'>
        </div>
    </div>
</div>
