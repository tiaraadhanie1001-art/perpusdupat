@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{
    checkinModal: false,
    purpose: 'Membaca',
    notes: '',
    submitCheckin() {
        fetch('{{ route('visits.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Alpine-Request': 'true'
            },
            body: JSON.stringify({
                purpose: this.purpose,
                notes: this.notes
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Alpine.store('toast').notify(data.message, 'success');
                this.checkinModal = false;
                setTimeout(() => window.location.reload(), 1000);
            } else {
                Alpine.store('toast').notify(data.message || 'Gagal melakukan presensi', 'error');
            }
        })
        .catch(() => {
            Alpine.store('toast').notify('Koneksi server LAN terganggu', 'error');
        });
    }
}">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 scroll-reveal">
        <div>
            <div class="text-xs font-semibold text-[#279b92] tracking-wide mb-1">
                Portal Layanan Siswa
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard Siswa</h1>
            <p class="text-xs text-gray-500 mt-1">
                Selamat datang, <span class="font-semibold text-gray-800">{{ auth()->user()->name }}</span> (NIS: {{ auth()->user()->nis_nip }}) &bull; Portal sirkulasi buku dan presensi mandiri.
            </p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
            <button type="button" @click="checkinModal = true" class="btn-press inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#279b92] hover:bg-[#1f8078] text-white text-xs font-medium shadow-2xs transition active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Presensi Kunjungan
            </button>
            <a href="{{ route('books.index') }}" class="btn-press inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white hover:bg-[#e1e5e6]/40 text-gray-700 text-xs font-medium border border-[#e1e5e6] shadow-2xs transition active:scale-[0.98]">
                Cari Buku
            </a>
        </div>
    </div>

    <!-- Student Stats (3 Cards with Scroll Reveal & Hover Lift) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Pinjaman Aktif -->
        <div class="scroll-reveal delay-1 bg-white p-4.5 rounded-xl border border-[#e1e5e6] shadow-xs card-hover group cursor-default">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-semibold tracking-wider text-gray-500 uppercase">Pinjaman Aktif</span>
                <div class="w-7 h-7 rounded-lg bg-[#e1e5e6]/60 flex items-center justify-center text-[#279b92] group-hover:scale-110 group-hover:bg-[#279b92] group-hover:text-white transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tracking-tight font-sans mt-3">{{ $stats['active_loans'] }}</div>
            <div class="text-[11px] text-gray-500 mt-1">Buku yang sedang Anda pinjam</div>
        </div>

        <!-- Selesai Dikembalikan -->
        <div class="scroll-reveal delay-2 bg-white p-4.5 rounded-xl border border-[#e1e5e6] shadow-xs card-hover group cursor-default">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-semibold tracking-wider text-gray-500 uppercase">Selesai Kembali</span>
                <div class="w-7 h-7 rounded-lg bg-[#e1e5e6]/60 flex items-center justify-center text-[#279b92] group-hover:scale-110 group-hover:bg-[#279b92] group-hover:text-white transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tracking-tight font-sans mt-3">{{ $stats['completed_loans'] }}</div>
            <div class="text-[11px] text-gray-500 mt-1">Total riwayat peminjaman</div>
        </div>

        <!-- Presensi Kunjungan -->
        <div class="scroll-reveal delay-3 bg-white p-4.5 rounded-xl border border-[#e1e5e6] shadow-xs card-hover group cursor-default">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-semibold tracking-wider text-gray-500 uppercase">Presensi Kunjungan</span>
                <div class="w-7 h-7 rounded-lg bg-[#e1e5e6]/60 flex items-center justify-center text-[#279b92] group-hover:scale-110 group-hover:bg-[#279b92] group-hover:text-white transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tracking-tight font-sans mt-3">{{ $stats['total_visits'] }}</div>
            <div class="text-[11px] text-gray-500 mt-1">Kehadiran di perpustakaan</div>
        </div>
    </div>

    <!-- Active Loans Section -->
    <div class="scroll-reveal delay-2 bg-white rounded-xl border border-[#e1e5e6] overflow-hidden shadow-xs card-hover">
        <div class="p-4 border-b border-[#e1e5e6] flex items-center justify-between">
            <div>
                <h2 class="font-bold text-gray-900 text-sm">Buku yang Sedang Dipinjam</h2>
                <p class="text-xs text-gray-500 mt-0.5">Pastikan mengembalikan tepat waktu sebelum tanggal jatuh tempo.</p>
            </div>
            <a href="{{ route('loans.index') }}" class="text-xs font-medium text-[#279b92] hover:underline flex items-center gap-1">
                <span>Lihat Semua Riwayat</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="divide-y divide-[#e1e5e6]/60">
            @forelse($myActiveLoans as $loan)
                @php
                    $isOverdue = \Carbon\Carbon::parse($loan->due_date)->isPast() && in_array($loan->status, ['dipinjam', 'terlambat']);
                @endphp
                <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-[#279b92]/5 hover:translate-x-0.5 transition-all duration-150">
                    <div class="flex items-start gap-3">
                        @if($loan->book?->cover_url)
                            <img src="{{ $loan->book->cover_url }}" alt="{{ $loan->book->title }}" class="w-12 h-15 rounded-lg object-cover border border-[#e1e5e6] shrink-0 shadow-2xs">
                        @else
                            <div class="w-12 h-15 rounded-lg bg-[#e1e5e6]/60 flex items-center justify-center text-[#279b92] shrink-0 shadow-2xs">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                        <div>
                            <div class="text-sm font-semibold text-gray-900 hover:text-[#279b92] transition">{{ $loan->book?->title ?? '-' }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">Penulis: {{ $loan->book?->author ?? 'Anonim' }} &bull; ISBN: {{ $loan->book?->isbn }}</div>
                            <div class="text-[11px] text-gray-400 mt-1">Lokasi Rak: <span class="font-medium text-gray-700 font-mono">{{ $loan->book?->rack_location ?? '-' }}</span></div>
                        </div>
                    </div>

                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-1 border-t sm:border-t-0 pt-2 sm:pt-0 border-gray-100">
                        @if($loan->status === 'menunggu_persetujuan')
                            <div class="flex flex-col items-end">
                                <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                    Menunggu Persetujuan
                                </span>
                                <span class="text-[10px] text-amber-600 mt-0.5 font-medium">Ambil di loket maks. 2 hari</span>
                            </div>
                        @elseif($isOverdue)
                            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                Terlambat (Jatuh Tempo: {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }})
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Dipinjam (Tempo: {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }})
                            </span>
                        @endif
                        <span class="text-[10px] text-gray-400 font-mono">Tgl Pinjam: {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-10 h-10 rounded-full bg-[#e1e5e6]/60 flex items-center justify-center text-[#279b92] mx-auto mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Tidak ada peminjaman buku yang sedang aktif.</p>
                    <p class="text-xs text-gray-400 mt-1">Ingin membaca buku? Jelajahi katalog dan ajukan peminjaman sekarang.</p>
                    <a href="{{ route('books.index') }}" class="btn-press inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#279b92] hover:bg-[#1f8078] text-white font-medium text-xs mt-4 shadow-2xs transition active:scale-[0.98]">
                        Jelajah Koleksi Buku
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Check-in Modal -->
    <div x-cloak x-show="checkinModal" class="fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.outside="checkinModal = false" class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-[#e1e5e6] space-y-4">
            <div class="flex items-center justify-between border-b border-[#e1e5e6] pb-3">
                <h3 class="font-bold text-gray-900 text-sm">Presensi Kunjungan Perpustakaan</h3>
                <button @click="checkinModal = false" class="text-gray-400 hover:text-gray-600 text-lg leading-none">&times;</button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Tujuan Kunjungan</label>
                    <select x-model="purpose" class="w-full px-3 py-2 border border-[#e1e5e6] rounded-lg text-xs bg-white focus:outline-none focus:ring-1 focus:ring-[#279b92] focus:border-[#279b92]">
                        <option value="Membaca">Membaca Buku / Referensi</option>
                        <option value="Meminjam">Meminjam / Mengembalikan Buku</option>
                        <option value="Tugas">Mengerjakan Tugas Sekolah</option>
                        <option value="Diskusi">Diskusi Belajar Kelompok</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Catatan Tambahan (Opsional)</label>
                    <input type="text" x-model="notes" placeholder="Contoh: Tugas Biologi Bab 3" class="w-full px-3 py-2 border border-[#e1e5e6] rounded-lg text-xs bg-white focus:outline-none focus:ring-1 focus:ring-[#279b92] focus:border-[#279b92]">
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#e1e5e6]">
                    <button type="button" @click="checkinModal = false" class="px-3.5 py-2 rounded-lg text-xs font-medium text-gray-700 bg-white border border-[#e1e5e6] hover:bg-[#e1e5e6]/40 transition active:scale-[0.98]">Batal</button>
                    <button type="button" @click="submitCheckin()" class="btn-press px-3.5 py-2 rounded-lg bg-[#279b92] hover:bg-[#1f8078] text-white text-xs font-medium shadow-2xs transition active:scale-[0.98]">
                        Simpan Presensi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
