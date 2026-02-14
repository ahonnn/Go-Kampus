

<x-app-layout>
    <div class="max-w-5xl mx-auto p-6 space-y-10">

        {{-- BAGIAN 1: TODAY'S HIGHLIGHT --}}
        <div>
            <flux:heading size="xl" class="mb-4">Jadwal Hari Ini ({{ $today }})</flux:heading>
            
            @if($todayClasses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($todayClasses as $class)
                        @php
                            $now = \Carbon\Carbon::now();
                            $start = \Carbon\Carbon::parse($class->start_time);
                            $end = \Carbon\Carbon::parse($class->end_time);
                            $isLive = $now->between($start, $end);
                            $isNext = $now->lt($start);
                        @endphp

                        <flux:card class="{{ $isLive ? 'border-indigo-500 ring-2 ring-indigo-500/20 bg-indigo-50/50 dark:bg-indigo-900/20' : '' }}">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    <!-- <div class="w-1.5 h-10 rounded-full" style="background-color: {{ $class->color }}"></div> -->
                                    <div>
                                        <h3 class="font-bold text-lg leading-none">{{ $class->name }}</h3>
                                        <p class="text-sm text-zinc-500 mt-1">{{ $start->format('H:i') }} - {{ $end->format('H:i') }} • R. {{ $class->room }}</p>
                                    </div>
                                </div>
                                
                                @if($isLive)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 animate-pulse">
                                        ● SEDANG BERLANGSUNG
                                    </span>
                                @elseif($isNext)
                                    <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded">
                                        Selanjutnya
                                    </span>
                                @else
                                    <span class="text-xs text-zinc-400">Selesai</span>
                                @endif
                            </div>
                        </flux:card>
                    @endforeach
                </div>
            @else
                <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800 text-center">
                    <p class="text-green-800 dark:text-green-300 font-medium">✨ Tidak ada kelas hari ini. Selamat beristirahat!</p>
                </div>
            @endif
        </div>

        <flux:separator />

        {{-- BAGIAN JADWAL MINGGUAN --}}
        <div>
            <div class="flex justify-between items-center mb-6">
                <flux:heading size="lg">Jadwal Mingguan</flux:heading>
                
                {{-- TOMBOL EXPORT GAMBAR --}}
                <flux:button id="btn-export" icon="camera" variant="primary" type="button">
                    Simpan Gambar
                </flux:button>
            </div>
            
            {{-- CONTAINER YANG AKAN DI-EXPORT --}}
            {{-- Kita beri ID "weekly-schedule" dan class bg-white agar backgroundnya tidak transparan saat difoto --}}
            <div id="weekly-schedule" class="
            w-full 
            h-full 
            font-sans 
            bg-[#1A5140] 
            bg-[image:linear-gradient(rgba(255,255,255,0.15)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.15)_1px,transparent_1px),linear-gradient(to_bottom_right,#5CA87C,#1A5140)] 
            bg-[length:40px_40px,40px_40px,100%_100%]
            p-5 
            rounded-xl 
            relative 
            overflow-hidden
            ">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
                
                {{-- Judul (Hanya muncul di hasil export, kita sembunyikan di tampilan web biar gak dobel) --}}
                <div class="mb-4 hidden export-only">
                    <h2 class="text-xl font-bold text-center">Jadwal Kuliah Semester Ini</h2>
                    <p class="text-sm text-center text-gray-500">{{ auth()->user()->name }}</p>
                </div>

                {{-- Grid Jadwal (Kode Lama Kamu) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden flex flex-col h-full shadow-sm">
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 px-4 py-3 border-b border-zinc-200 dark:border-zinc-800 font-bold text-zinc-700 dark:text-zinc-300">
                                {{ $day }}
                            </div>
                            <div class="p-4 space-y-4 flex-1">
                                @if(isset($weeklySchedule[$day]))
                                    @foreach($weeklySchedule[$day] as $s)
                                        <div class="flex gap-3 relative group">
                                            <div class="flex flex-col items-center">
                                                <div class="w-2 h-2 rounded-full mt-1.5" style="background-color: {{ $s->color }}"></div>
                                                <div class="w-0.5 h-full bg-zinc-100 dark:bg-zinc-800 group-last:hidden"></div>
                                            </div>
                                            <div class="pb-4">
                                                <div class="text-xs font-mono text-zinc-500 mb-0.5">
                                                    {{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}
                                                </div>
                                                <div class="font-medium text-sm text-zinc-900 dark:text-white">
                                                    {{ $s->name }}
                                                </div>
                                                <div class="text-xs text-zinc-500 truncate">
                                                    {{ $s->room }} • {{ $s->lecturer }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-xs text-zinc-400 italic py-2 text-center">Libur</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>

    {{-- SCRIPT JAVASCRIPT EXPORT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnExport = document.getElementById('btn-export');
        
        btnExport.addEventListener('click', function() {
            if (typeof htmlToImage === 'undefined') {
                alert('Error: Library html-to-image gagal dimuat.');
                return;
            }

            const originalText = btnExport.innerText;
            btnExport.innerText = '✨ Magic Process...';
            btnExport.disabled = true;
            
            const element = document.getElementById('weekly-schedule');
            const exportHeader = document.getElementById('export-header');

            // 1. Tampilkan Header
            if(exportHeader) {
                exportHeader.style.display = 'block';
                exportHeader.style.color = 'white'; 
                exportHeader.style.textShadow = '0 2px 4px rgba(0,0,0,0.3)';
                exportHeader.style.marginBottom = '20px'; // Beri jarak sedikit ke tabel
            }

            // --- LOGIC ANTI-CROP ---
            const padding = 60; // Ukuran frame (60px)
            const originalWidth = element.offsetWidth;
            const originalHeight = element.offsetHeight;

            // 2. Konfigurasi Foto
            htmlToImage.toPng(element, {
                quality: 1.0,
                pixelRatio: 2, // Resolusi HD
                
                // PENTING: Paksa ukuran kanvas jadi lebih besar
                width: originalWidth + (padding * 2),
                height: originalHeight + (padding * 2),
                
                style: {
                    // Paksa ukuran elemen clone agar pas dengan kanvas baru
                    width: (originalWidth + (padding * 2)) + 'px',
                    height: (originalHeight + (padding * 2)) + 'px',
                    boxSizing: 'border-box', // Agar padding dihitung di dalam lebar total

                    // --- STYLE JADE HORIZON ---
                    padding: `${padding}px`,
                    backgroundImage: `
                        linear-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(255, 255, 255, 0.15) 1px, transparent 1px),
                        linear-gradient(to bottom right, #5CA87C, #1A5140)
                    `,
                    backgroundSize: '40px 40px, 40px 40px, 100% 100%',
                    backgroundColor: '#1A5140',
                    fontFamily: 'sans-serif'
                }
            })
            .then(function (dataUrl) {
                const link = document.createElement('a');
                link.download = 'Jadwal-Jade-Horizon.png';
                link.href = dataUrl;
                link.click();

                // Reset
                if(exportHeader) {
                    exportHeader.style.display = 'none';
                    exportHeader.style.color = '';
                    exportHeader.style.textShadow = '';
                    exportHeader.style.marginBottom = '';
                }
                btnExport.innerText = originalText;
                btnExport.disabled = false;
            })
            .catch(function (error) {
                console.error('Gagal export:', error);
                alert('Gagal membuat gambar.');
                if(exportHeader) exportHeader.style.display = 'none';
                btnExport.innerText = originalText;
                btnExport.disabled = false;
            });
        });
    });
</script>

</x-app-layout>