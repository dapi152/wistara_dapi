<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisatara - Marketplace Pemandu Wisata Lokal & Private Tour</title>
    <!-- Tailwind CSS CDN & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#effcf7',
                            100: '#d7f7eb',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Hero Background Slideshow */
        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .hero-bg img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        .hero-bg img.active {
            opacity: 1;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(2,20,10,0.55) 0%, rgba(5,40,20,0.65) 60%, rgba(2,15,8,0.80) 100%);
            z-index: 1;
        }
        [data-aos] {
            pointer-events: none;
        }
        [data-aos].aos-animate {
            pointer-events: auto;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-emerald-400 flex items-center justify-center text-white font-bold text-xl shadow-md shadow-brand-500/20">W</span>
                <div>
                    <span class="text-2xl font-black tracking-tight text-slate-900">Wisatara</span>
                    <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-xs font-semibold bg-brand-50 text-brand-700 rounded-full border border-brand-200">Private Tour</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                <a href="#destinasi" class="hover:text-brand-600 transition">Destinasi</a>
                <a href="#kategori" class="hover:text-brand-600 transition">Pengalaman</a>
                <a href="#pemandu" class="hover:text-brand-600 transition">Pemandu Lokal</a>
                <a href="#paket" class="hover:text-brand-600 transition">Paket Tur</a>
                <a href="#keunggulan" class="hover:text-brand-600 transition">Tentang Kami</a>
            </nav>

            <div class="flex items-center space-x-3">
                @guest
                    <a href="/login" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-brand-600 transition">
                        Masuk
                    </a>
                    <a href="/register" class="px-5 py-2.5 text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 rounded-full transition shadow-sm shadow-brand-500/20">
                        Daftar Akun
                    </a>
                @else
                    <!-- Profile Dropdown Component -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" 
                                class="flex items-center space-x-2.5 p-1.5 pr-3 rounded-full border border-slate-200 hover:border-slate-300 hover:shadow-sm bg-white transition cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand-600 to-teal-400 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <span class="text-xs font-bold text-slate-700">Profil</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl shadow-slate-200/80 border border-slate-200 py-2 z-50 text-xs" style="display: none;">
                            
                            <!-- Header Info Pengguna -->
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="font-bold text-slate-800 text-sm truncate">{{ Auth::user()->name }}</p>
                                <p class="text-slate-400 truncate mt-0.5 text-[11px]">{{ Auth::user()->email }}</p>
                                <span class="inline-block mt-1.5 px-2 py-0.5 text-[10px] font-bold rounded-md uppercase tracking-wider
                                    {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ Auth::user()->role === 'pemandu' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ Auth::user()->role === 'wisatawan' ? 'bg-blue-100 text-blue-700' : '' }}">
                                    {{ Auth::user()->role === 'admin' ? 'Administrator' : (Auth::user()->role === 'pemandu' ? 'Pemandu Lokal' : 'Wisatawan') }}
                                </span>
                            </div>

                            <!-- Menu Aksi Sesuai Role -->
                            <div class="py-1">
                                @if(Auth::user()->role === 'admin')
                                    <a href="/admin" class="flex items-center space-x-2 px-4 py-2 text-slate-700 hover:bg-slate-50 font-semibold transition">
                                        <span>⚙️</span>
                                        <span>Panel Admin</span>
                                    </a>
                                @elseif(Auth::user()->role === 'pemandu')
                                    <a href="/pemandu/dashboard" class="flex items-center space-x-2 px-4 py-2 text-slate-700 hover:bg-slate-50 font-semibold transition">
                                        <span>🧭</span>
                                        <span>Dasbor Pemandu</span>
                                    </a>
                                @else
                                    <a href="/wisatawan/dashboard" class="flex items-center space-x-2 px-4 py-2 text-slate-700 hover:bg-slate-50 font-semibold transition">
                                        <span>🎒</span>
                                        <span>Reservasi Saya</span>
                                    </a>
                                @endif
                            </div>

                            <!-- Tombol Keluar -->
                            <div class="border-t border-slate-100 pt-1 mt-1">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center space-x-2 px-4 py-2 text-rose-600 hover:bg-rose-50 font-bold transition">
                                        <span>🚪</span>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative min-h-[92vh] flex items-center overflow-hidden">
        <!-- Background Image Slideshow -->
        <div class="hero-bg">
            <img src="https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?auto=format&fit=crop&w=1920&q=85" alt="Bali" class="active">
            <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=1920&q=85" alt="Bromo">
            <img src="https://images.unsplash.com/photo-1573790387438-4da905039392?auto=format&fit=crop&w=1920&q=85" alt="Labuan Bajo">
            <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1920&q=85" alt="Yogyakarta">
        </div>
        <!-- Dark Gradient Overlay -->
        <div class="hero-overlay"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 py-24 w-full">
            <span data-aos="fade-down" data-aos-duration="800" class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm text-emerald-300 border border-emerald-400/30 text-xs font-bold tracking-wide uppercase mb-6">
                ✨ Marketplace Pemandu Lokal Terverifikasi
            </span>
            <h1 data-aos="fade-up" data-aos-duration="900" data-aos-delay="100" class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight max-w-4xl mx-auto leading-tight drop-shadow-lg">
                Jelajahi Nusantara Bersama Warga Lokal,
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-300">100% Private &amp; Fleksibel</span>
            </h1>
            <p data-aos="fade-up" data-aos-duration="900" data-aos-delay="200" class="mt-6 text-lg sm:text-xl text-white/80 max-w-2xl mx-auto font-normal drop-shadow">
                Temukan pemandu wisata terpercaya sesuai minat Anda — mulai dari tur kuliner jalanan legendaris, sejarah budaya, hingga eksplorasi alam tersembunyi.
            </p>

            <!-- SEARCH FILTER BOX -->
            <div data-aos="fade-up" data-aos-duration="900" data-aos-delay="300" class="mt-10 max-w-4xl mx-auto bg-white/95 backdrop-blur-md p-4 rounded-3xl shadow-2xl shadow-black/30 border border-white/50">
                <form action="/" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                    <!-- Pilih Kota -->
                    <div class="text-left px-4 py-2 bg-slate-50 rounded-2xl border border-slate-200/80">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kota Destinasi</label>
                        <select name="kota" class="mt-1 w-full bg-transparent text-sm font-semibold text-slate-800 focus:outline-none cursor-pointer">
                            <option value="">Semua Kota di Indonesia</option>
                            @foreach($kotaList as $kota)
                                <option value="{{ $kota->id_kota }}" {{ request('kota') == $kota->id_kota ? 'selected' : '' }}>
                                    {{ $kota->nama_kota }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kategori Pengalaman -->
                    <div class="text-left px-4 py-2 bg-slate-50 rounded-2xl border border-slate-200/80">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori Pengalaman</label>
                        <select name="kategori" class="mt-1 w-full bg-transparent text-sm font-semibold text-slate-800 focus:outline-none cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Cari -->
                    <div>
                        <button type="submit" class="w-full h-14 bg-gradient-to-r from-brand-600 to-emerald-500 hover:from-brand-700 hover:to-emerald-600 text-white font-bold rounded-2xl transition shadow-lg shadow-brand-500/25 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Temukan Tur</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Scroll Indicator -->
            <div data-aos="fade-up" data-aos-delay="600" class="mt-12 flex flex-col items-center space-y-2 text-white/50">
                <span class="text-xs font-semibold tracking-widest uppercase">Scroll untuk Jelajahi</span>
                <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>
    </section>

    <!-- SECTION KATEGORI WISATA -->
    <section id="kategori" class="py-16 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div data-aos="fade-up" data-aos-duration="700" class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Kategori Pengalaman Unik</h2>
                    <p class="text-slate-500 mt-1">Pilih gaya liburan privat sesuai keinginan Anda.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($kategoriList as $kategori)
                    <div data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ $loop->index * 100 }}" class="p-6 rounded-2xl border border-slate-200 hover:border-brand-500 hover:shadow-lg transition group bg-slate-50 hover:bg-white">
                        <div class="w-12 h-12 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center text-xl font-bold mb-4 group-hover:scale-110 transition">
                            🧭
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 group-hover:text-brand-600 transition">{{ $kategori->nama_kategori }}</h3>
                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">{{ $kategori->deskripsi }}</p>
                        <span class="inline-block mt-4 text-xs font-semibold text-brand-600">{{ $kategori->paket_tur_count }} Tur Tersedia &rarr;</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION DESTINASI KOTA POPULER -->
    <section id="destinasi" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div data-aos="fade-up" data-aos-duration="700" class="mb-10 text-center sm:text-left">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Kota Destinasi Pilihan</h2>
                <p class="text-slate-500 mt-1">Jelajahi sudut terbaik Indonesia bersama warga lokal di kota ini.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($kotaList as $kota)
                    <div data-aos="zoom-in" data-aos-duration="600" data-aos-delay="{{ $loop->index * 100 }}" class="relative group rounded-3xl overflow-hidden shadow-md aspect-[4/5] bg-slate-800">
                        <img src="{{ $kota->foto_kota ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80' }}" 
                             alt="{{ $kota->nama_kota }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-80 group-hover:opacity-90">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/30 to-transparent"></div>
                        <div class="absolute bottom-0 inset-x-0 p-6 text-white">
                            <span class="text-xs uppercase tracking-wider font-semibold text-emerald-400">{{ $kota->provinsi }}</span>
                            <h3 class="text-xl font-bold mt-1">{{ $kota->nama_kota }}</h3>
                            <div class="flex items-center space-x-3 mt-3 text-xs text-slate-300">
                                <span>👥 {{ $kota->pemandu_count }} Pemandu</span>
                                <span>•</span>
                                <span>🎒 {{ $kota->paket_tur_count }} Paket Tur</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION PEMANDU WISATA TERVERIFIKASI -->
    <section id="pemandu" class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div data-aos="fade-up" data-aos-duration="700" class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-12">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Terpercaya & Berpengalaman</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Pemandu Lokal Wisatara</h2>
                    <p class="text-slate-500 mt-1">Profil terverifikasi dengan ulasan asli dari wisatawan terdahulu.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($pemanduList as $pemandu)
                    <div data-aos="fade-up" data-aos-duration="700" data-aos-delay="{{ $loop->index * 100 }}" class="bg-slate-50 rounded-3xl p-6 border border-slate-200 hover:shadow-xl transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-4 mb-5">
                                <img src="{{ $pemandu->foto_profil ?? 'https://ui-avatars.com/api/?name='.urlencode($pemandu->nama_pemandu) }}" 
                                     alt="{{ $pemandu->nama_pemandu }}" 
                                     class="w-16 h-16 rounded-2xl object-cover border-2 border-brand-500 shadow-sm">
                                <div>
                                    <div class="flex items-center space-x-1.5">
                                        <h3 class="font-bold text-lg text-slate-900">{{ $pemandu->nama_pemandu }}</h3>
                                        <span title="Terverifikasi Admin" class="text-brand-600">
                                            <svg class="w-5 h-5 inline-block fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-brand-700 bg-brand-50 inline-block px-2 py-0.5 rounded-md mt-0.5">
                                        📍 {{ $pemandu->kota->nama_kota ?? 'Indonesia' }}
                                    </p>
                                </div>
                            </div>

                            <p class="text-sm font-semibold text-slate-800 italic mb-2">"{{ $pemandu->tagline_pemandu ?? 'Pemandu Lokal Berpengalaman' }}"</p>
                            <p class="text-sm text-slate-600 line-clamp-3 mb-4 leading-relaxed">{{ $pemandu->tentang_saya }}</p>

                            <!-- Bahasa -->
                            <div class="mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Bahasa yang Dikuasai:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($pemandu->bahasa as $bahasa)
                                        <span class="px-2 py-0.5 bg-white border border-slate-200 text-xs font-medium rounded-full text-slate-700">
                                            🗣️ {{ $bahasa->nama_bahasa }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400">Bahasa Indonesia</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-200 flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-1 text-amber-500 font-bold">
                                <span>⭐</span>
                                <span class="text-slate-900">{{ $pemandu->rata_rata_rating }}</span>
                                <span class="text-xs text-slate-400 font-normal">({{ $pemandu->ulasan->count() }} ulasan)</span>
                            </div>
                            <span class="px-3 py-1 bg-emerald-100 text-brand-800 font-semibold text-xs rounded-full">
                                {{ $pemandu->status_ketersediaan }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-slate-400">Belum ada pemandu lokal terverifikasi.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION PAKET TUR PRIVAT (EXPERIENCES) -->
    <section id="paket" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div data-aos="fade-up" data-aos-duration="700" class="mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Eksklusif & Autentik</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Paket Tur Privat Populer</h2>
                <p class="text-slate-500 mt-1">Hanya rombongan Anda sendiri. Rute perjalanan dapat disesuaikan!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($paketList as $paket)
                    <div data-aos="fade-up" data-aos-duration="700" data-aos-delay="{{ $loop->index * 100 }}" class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition border border-slate-200 flex flex-col justify-between">
                        <div>
                            <div class="relative h-56 bg-slate-200">
                                <img src="{{ $paket->foto_sampul ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80' }}" 
                                     alt="{{ $paket->judul_tur }}" 
                                     class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-slate-800 shadow">
                                    {{ $paket->kategori->nama_kategori ?? 'Private Tour' }}
                                </div>
                                @if($paket->bisa_kustom)
                                    <div class="absolute top-4 right-4 bg-emerald-600 text-white px-2.5 py-1 rounded-full text-xs font-semibold shadow">
                                        ✨ 100% Bisa Kustom
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="flex items-center space-x-2 text-xs text-slate-500 mb-2">
                                    <span>📍 {{ $paket->kota->nama_kota ?? 'Destinasi' }}</span>
                                    <span>•</span>
                                    <span>⏱️ {{ $paket->durasi_jam }} Jam</span>
                                    <span>•</span>
                                    <span>👥 Maks. {{ $paket->kuota_maksimal }} Orang</span>
                                </div>

                                <h3 class="font-extrabold text-lg text-slate-900 leading-snug mb-3 hover:text-brand-600 transition">
                                    {{ $paket->judul_tur }}
                                </h3>

                                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-4">
                                    {{ $paket->deskripsi_tur }}
                                </p>

                                <!-- Itinerary Spots -->
                                @if($paket->itinerary->count() > 0)
                                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 mb-4">
                                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Rute Singgah (Itinerary):</span>
                                        <ul class="text-xs text-slate-700 space-y-1">
                                            @foreach($paket->itinerary as $spot)
                                                <li class="flex items-center space-x-1.5">
                                                    <span class="w-4 h-4 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-[10px]">{{ $spot->urutan_ke }}</span>
                                                    <span class="font-medium truncate">{{ $spot->nama_lokasi_spot }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 pt-0 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-slate-400 block font-medium">Mulai dari</span>
                                <span class="text-lg font-black text-brand-600">Rp {{ number_format($paket->harga_per_orang, 0, ',', '.') }}</span>
                                <span class="text-xs text-slate-500">/ orang</span>
                            </div>
                            <a href="/paket/{{ $paket->id_paket }}/pesan" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl transition shadow-md shadow-brand-500/20 flex items-center space-x-1">
                                <span>Pesan Tur</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION KEUNGGULAN (VALUE PROPOSITION) -->
    <section id="keunggulan" class="py-20 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div data-aos="fade-up" data-aos-duration="700" class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase">Standar Kualitas Wisatara</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold mt-2">Mengapa Berlibur Lewat Wisatara?</h2>
                <p class="text-slate-400 mt-4 leading-relaxed">Kami mengubah cara Anda menikmati Indonesia menjadi lebih bermakna, personal, dan tanpa kerumitan rombongan besar.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div data-aos="fade-up" data-aos-duration="700" data-aos-delay="0" class="bg-slate-800/60 p-8 rounded-3xl border border-slate-700/60">
                    <div class="w-12 h-12 bg-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-2xl font-bold mb-6">
                        🔒
                    </div>
                    <h3 class="text-xl font-bold mb-3">100% Private Tour</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Tidak ada orang asing dalam rombongan Anda. Tur hanya didedikasikan untuk Anda, keluarga, atau sahabat terdekat.
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-duration="700" data-aos-delay="150" class="bg-slate-800/60 p-8 rounded-3xl border border-slate-700/60">
                    <div class="w-12 h-12 bg-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-2xl font-bold mb-6">
                        ✏️
                    </div>
                    <h3 class="text-xl font-bold mb-3">Bisa Kustomisasi Rute</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Ingin mampir ke toko suvenir khas atau menghindari makanan tertentu? Cukup tulis catatan kustomisasi dan pemandu akan menyesuaikan rutenya.
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-duration="700" data-aos-delay="300" class="bg-slate-800/60 p-8 rounded-3xl border border-slate-700/60">
                    <div class="w-12 h-12 bg-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-2xl font-bold mb-6">
                        🛡️
                    </div>
                    <h3 class="text-xl font-bold mb-3">Pemandu Terverifikasi</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Setiap pemandu lokal melalui proses verifikasi data oleh Admin Wisatara untuk memastikan keamanan, keahlian bahasa, dan kenyamanan Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-sm text-slate-500 space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-2">
                <span class="font-extrabold text-slate-900 text-lg">Wisatara</span>
                <span>— Website Marketplace Pemandu Wisata Lokal & Private Tour</span>
            </div>
            <div>
                <span>© 2026 Wisatara. PSAS Basis Data SMK Telkom Purwokerto.</span>
            </div>
        </div>
    </footer>

<!-- AOS Init Script -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        offset: 60,
        easing: 'ease-out-cubic',
    });

    // Hero Background Slideshow
    const heroImgs = document.querySelectorAll('.hero-bg img');
    let currentImg = 0;
    if (heroImgs.length > 1) {
        setInterval(() => {
            heroImgs[currentImg].classList.remove('active');
            currentImg = (currentImg + 1) % heroImgs.length;
            heroImgs[currentImg].classList.add('active');
        }, 5000);
    }
</script>
</body>
</html>
