<x-layouts::auth :title="__('Register')">
    <!-- PAKSA BACKGROUND UTAMA: Menggunakan !important agar tidak ditimpa layout bawaan -->
    <div style="position: fixed !important; inset: 0 !important; background: linear-gradient(to bottom, #A2E3D4, #C2F0E5) !important; display: flex !important; align-items: center !important; justify-content: center !important; padding: 1rem !important; overflow-y: auto !important; z-index: 99999 !important;">
        
        <!-- CARD UTAMA -->
        <div style="background: linear-gradient(to bottom, #A2E3D4, #C2F0E5) !important; padding: 2.5rem 2rem; border-radius: 2rem; border: 4px solid #000000; box-shadow: 8px 8px 0px 0px rgba(0,0,0,1); display: flex; flex-direction: column; align-items: center; gap: 1.5rem; text-align: center; width: 100%; max-width: 420px; color: #000000; box-sizing: border-box;">
            
            <!-- Logo & Header STUDIO IMUT -->
            <div class="flex flex-col items-center gap-3">
                <!-- Icon Kamera Kotak Tebal -->
                <div style="background-color: #EFFFFC !important; padding: 0.75rem; border-radius: 1rem; border: 2px solid #000000; box-shadow: 4px 4px 0px 0px rgba(0,0,0,1); color: #000000; display: inline-block;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 2rem; height: 2rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </div>
                
                <!-- Nama Brand -->
                <h1 class="font-sans italic text-3xl font-black tracking-tighter text-black uppercase flex items-baseline mt-2">
                    STUDIO IMUT<span class="text-[#0091FF] font-black">.</span>
                </h1>
                <p class="font-sans font-bold text-xs tracking-widest text-black uppercase -mt-2">
                    STUDIO PHOTO
                </p>
            </div>

            <!-- Judul Form -->
            <h2 class="font-sans font-bold text-base tracking-wide text-black uppercase">
                {{ __('Daftar Akun Baru') }}
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="text-center w-full" :status="session('status')" />

            <!-- Form Pendaftaran -->
            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4 w-full" style="width: 100%;">
                @csrf

                <!-- Name -->
                <div class="text-left flex flex-col gap-1 w-full">
                    <span class="text-sm font-bold text-black ml-1">{{ __('Nama Lengkap') }}</span>
                    <flux:input
                        name="name"
                        :value="old('name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="nama kamu"
                        style="background: linear-gradient(to bottom, #BCEFE4, #EFFFFC) !important; border: 2px solid #000000 !important; border-radius: 0.75rem !important; color: #000000 !important; width: 100%; box-sizing: border-box;"
                    />
                </div>

                <!-- Email Address -->
                <div class="text-left flex flex-col gap-1 w-full">
                    <span class="text-sm font-bold text-black ml-1">{{ __('Alamat Email') }}</span>
                    <flux:input
                        name="email"
                        :value="old('email')"
                        type="email"
                        required
                        autocomplete="email"
                        placeholder="nama-kamu@domain.com"
                        style="background: linear-gradient(to bottom, #BCEFE4, #EFFFFC) !important; border: 2px solid #000000 !important; border-radius: 0.75rem !important; color: #000000 !important; width: 100%; box-sizing: border-box;"
                    />
                </div>

                <!-- Password -->
                <div class="text-left flex flex-col gap-1 w-full">
                    <span class="text-sm font-bold text-black ml-1">{{ __('Kata Sandi') }}</span>
                    <flux:input
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                        viewable
                        style="background: linear-gradient(to bottom, #BCEFE4, #EFFFFC) !important; border: 2px solid #000000 !important; border-radius: 0.75rem !important; color: #000000 !important; width: 100%; box-sizing: border-box;"
                    />
                </div>

                <!-- Confirm Password -->
                <div class="text-left flex flex-col gap-1 w-full">
                    <span class="text-sm font-bold text-black ml-1">{{ __('Konfirmasi Kata Sandi') }}</span>
                    <flux:input
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                        viewable
                        style="background: linear-gradient(to bottom, #BCEFE4, #EFFFFC) !important; border: 2px solid #000000 !important; border-radius: 0.75rem !important; color: #000000 !important; width: 100%; box-sizing: border-box;"
                    />
                </div>

                <!-- Tombol Submit Neo-Brutalism -->
                <div class="mt-3 w-full">
                    <!-- BACKGROUND tombol diubah jadi Pink (#FF1493), tulisan diubah jadi Hitam (#000000) dan bayangan hitam tebal -->
                    <button 
                        type="submit" 
                        style="width: 100%; text-transform: uppercase; font-weight: 900; letter-spacing: 0.05em; background-color: #FF1493; color: #000000 !important; padding: 0.75rem 0; border-radius: 0.75rem; border: 2px solid #000000; box-shadow: 4px 4px 0px 0px rgba(0,0,0,1); cursor: pointer;"
                    >
                        {{ __('Daftar') }}
                    </button>
                </div>
            </form>

            <!-- Link ke Login -->
            <div class="text-sm text-black mt-2 font-bold">
                <span>{{ __('Sudah punya akun?') }}</span>
                <flux:link :href="route('login')" wire:navigate style="color: #FF1493 !important; font-weight: 900; text-decoration: underline !important;">
                    {{ __('Masuk Sekarang') }}
                </flux:link>
            </div>
        </div>
    </div>
</x-layouts::auth>