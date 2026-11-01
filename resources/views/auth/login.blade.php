<!DOCTYPE html>
<html lang="id" class="h-full bg-[#f6f8fa]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Sistem Perpustakaan Digital</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center p-4 font-sans text-gray-900 bg-[#f6f8fa]" x-data="{
    fillCredentials(login, password) {
        $refs.loginInput.value = login;
        $refs.passwordInput.value = password;
    }
}">
    <div class="max-w-md w-full">
        <!-- Logo & Header with Scroll-Reveal -->
        <div class="text-center mb-6 scroll-reveal">
            <div class="inline-flex w-12 h-12 rounded-xl bg-[#279b92] text-white items-center justify-center mb-3 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">PERPUS DUPAT</h1>
            <p class="text-xs text-gray-500 mt-1">Perpustakaan Digital Terpadu &bull; SMA Negeri 24 Bandung</p>
        </div>

        <!-- Login Card with Card-Hover & Elevation -->
        <div class="scroll-reveal delay-1 bg-white rounded-2xl border border-[#e1e5e6] p-6 sm:p-8 shadow-xs card-hover">
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-800 text-xs border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Login Identifier (NIS, NIP, or Email) -->
                <div>
                    <label for="login" class="block text-xs font-medium text-gray-700 mb-1.5">
                        NIS / NIP / Email
                    </label>
                    <input type="text"
                           name="login"
                           id="login"
                           x-ref="loginInput"
                           value="{{ old('login') }}"
                           required
                           autofocus
                           placeholder="Contoh: admin atau 2024101"
                           class="w-full px-3 py-2.5 rounded-lg border border-[#e1e5e6] text-xs focus:ring-1 focus:ring-[#279b92] focus:border-[#279b92] outline-none transition bg-white @error('login') border-rose-400 @enderror">
                    @error('login')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-medium text-gray-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <input type="password"
                           name="password"
                           id="password"
                           x-ref="passwordInput"
                           required
                           placeholder="••••••••"
                           class="w-full px-3 py-2.5 rounded-lg border border-[#e1e5e6] text-xs focus:ring-1 focus:ring-[#279b92] focus:border-[#279b92] outline-none transition bg-white @error('password') border-rose-400 @enderror">
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded text-[#279b92] border-[#e1e5e6] focus:ring-[#279b92]">
                        <span class="text-xs text-gray-600">Ingat Saya</span>
                    </label>
                    <span class="text-[11px] text-gray-400 font-mono">Node LAN Server</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-press w-full py-2.5 px-4 rounded-lg bg-[#279b92] hover:bg-[#1f8078] text-white font-medium text-xs shadow-2xs transition flex items-center justify-center gap-1.5 active:scale-[0.98]">
                    Masuk ke Sistem
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <!-- Quick Demo Login Presets with Hover Lift -->
            <div class="mt-6 pt-5 border-t border-[#e1e5e6]">
                <div class="text-[11px] font-medium text-gray-400 text-center mb-2.5">
                    Demo Akun Pengujian (Klik untuk Isi):
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button"
                            @click="fillCredentials('admin', 'password')"
                            class="p-2.5 text-xs rounded-xl bg-[#e1e5e6]/30 hover:bg-[#279b92]/5 hover:border-[#279b92]/40 border border-[#e1e5e6] hover:-translate-y-0.5 transition-all text-left active:scale-[0.98]">
                        <span class="block font-semibold text-gray-900">Pustakawan</span>
                        <span class="text-[10px] text-gray-500 font-mono">admin (NIP)</span>
                    </button>
                    <button type="button"
                            @click="fillCredentials('2024101', 'password')"
                            class="p-2.5 text-xs rounded-xl bg-[#e1e5e6]/30 hover:bg-[#279b92]/5 hover:border-[#279b92]/40 border border-[#e1e5e6] hover:-translate-y-0.5 transition-all text-left active:scale-[0.98]">
                        <span class="block font-semibold text-gray-900">Siswa (Ahmad)</span>
                        <span class="text-[10px] text-gray-500 font-mono">2024101 (NIS)</span>
                    </button>
                </div>
            </div>

            <!-- Kiosk Station Quick Link -->
            <div class="mt-5 text-center">
                <a href="{{ route('kiosk.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-[#279b92] hover:text-[#1f8078] hover:underline">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#279b92] animate-pulse"></span>
                    Menuju Kiosk Presensi Mandiri Siswa &rarr;
                </a>
            </div>
        </div>
    </div>
</body>
</html>
