<x-layouts::auth :title="__('Masuk')">
    <!-- TRICK: Suntik CSS Langsung ke Sistem Utama Layout -->
    <style>
        /* Paksa body dan container paling luar layout berubah menjadi gradasi cream-putih */
        body, 
        .min-h-screen, 
        [class*="bg-white"], 
        [class*="bg-zinc"] {
            background: linear-gradient(180deg, #55a19b 0%, #fcfff6 100%) !important;
        }
    </style>

    <!-- KARTU LOGIN UTAMA -->
    <div class="relative flex flex-col items-center justify-center min-h-screen px-4 py-12 overflow-hidden selection:bg-rose-200">
        
        <!-- Elemen Estetik Lingkaran Blur (Pink & Hijau Sage) -->
        <div class="absolute top-[-10%] left-[-10%] w-[300px] h-[300px] rounded-full blur-3xl pointer-events-none" style="background-color: rgba(251, 182, 206, 0.4);"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[350px] h-[350px] rounded-full blur-3xl pointer-events-none" style="background-color: rgba(167, 243, 208, 0.5);"></div>

        <div class="w-full max-w-md p-8 bg-white border-4 border-zinc-950 rounded-3xl shadow-[8px_8px_0px_0px_rgba(24,24,27,1)] relative z-10">
            
            <!-- Logo & Header Brand FAGE -->
            <div class="flex flex-col items-center mb-8 text-center">
                <!-- Icon Kamera dengan Badge Warna Hijau Sage (#D1E7DD) -->
                <div class="p-3 border-4 border-zinc-950 rounded-2xl text-zinc-950 shadow-[3px_3px_0px_0px_rgba(24,24,27,1)]" style="background-color: #D1E7DD;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"></path>
                    </svg>
                </div>
                
                <h1 class="mt-4 text-4xl font-black tracking-tighter text-zinc-950 uppercase italic">
                    STUDIO IMUT<span style="color: #1096d4;">.</span>
                </h1>
                <p class="text-xs font-bold tracking-[0.2em] uppercase mt-0.5" style="color: #000000 !important;">
                  Studio Photo
                </p>
                </p>
            </div>

            <!-- Status Sesi -->
            <x-auth-session-status class="mb-4 text-center font-bold text-zinc-950" :status="session('status')" />

            <!-- Passkey -->
            <x-passkey-verify />

            <!-- Form Utama -->
            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                <!-- Input Email -->
                <div>
                    <flux:input
                        name="email"
                        :label="__('Alamat Email')"
                        :value="old('email')"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="nama-kamu@domain.com"
                        class="border-4 border-zinc-950 rounded-xl p-3 focus:ring-0"
                    />
                </div>

                <!-- Input Kata Sandi -->
                <div class="relative">
                    <flux:input
                        name="password"
                        :label="__('Kata Sandi')"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        viewable
                        class="border-4 border-zinc-950 rounded-xl p-3 focus:ring-0"
                    />
                    
                    @if (Route::has('password.request'))
                        <flux:link class="absolute top-0 text-xs font-bold text-zinc-500 end-0 hover:text-zinc-950 transition-colors underline" :href="route('password.request')" wire:navigate>
                            {{ __('Lupa?') }}
                        </flux:link>
                    @endif
                </div>

                <!-- Ingat Saya -->
                <div class="flex items-center justify-between">
                    <flux:checkbox name="remember" :label="__('Biarkan saya tetap masuk')" class="font-bold text-zinc-950" />
                </div>

                <!-- TOMBOL MASUK UTAMA -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-4.5 font-black text-zinc-950 uppercase border-4 border-zinc-950 rounded-2xl shadow-[4px_4px_0px_0px_rgba(24,24,27,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[2px_2px_0px_0px_rgba(24,24,27,1)] transition-all duration-150 text-center flex justify-center items-center text-md tracking-wider" style="background-color: #FFB6C1;" data-test="login-button">
                        {{ __('MASUK') }}
                    </button>
                </div>
            </form>

            <!-- Pembatas Bintang Estetik -->
            <div class="relative flex items-center justify-center my-6">
                <div class="absolute w-full border-t-2 border-zinc-950"></div>
                <span class="relative px-3 text-[10px] font-bold text-zinc-950 bg-white uppercase tracking-widest">★ ★ ★</span>
            </div>

            <!-- Footer Daftar Akun Baru -->
            <div class="mt-4 text-xs font-bold text-center text-zinc-600">
                <span>{{ __('Belum punya akun?') }}</span>
                <flux:link :href="route('register')" class="ml-1 text-zinc-950 underline decoration-4 underline-offset-4 hover:text-zinc-700" style="text-decoration-color: #A7F3D0;" wire:navigate>
                    {{ __('Buat akun sekarang') }}
                </flux:link>
            </div>

        </div>
    </div>
</x-layouts::auth>