<x-app-layout>


{{-- Pembungkus Utama Dark Mode --}}
<div class="max-w-7xl mx-auto text-white p-6 md:p-8 rounded-3xl font-sans">

    {{-- 🌟 PEMBUNGKUS ALPINE.JS UNTUK LOADING --}}
    <div x-data="{ isLoading: true }" x-init="setTimeout(() => isLoading = false, 600)">

        {{-- ========================================== --}}
        {{-- 1. SKELETON LOADING (Tampil saat memuat) --}}
        {{-- ========================================== --}}
        <div x-show="isLoading" class="space-y-8">
            
            {{-- SKELETON SECTION 1: HERO & CARDS --}}
            <div class="flex flex-col lg:flex-row gap-4">
                {{-- Skeleton Hero Banner --}}
                <div class="bg-[#202020] animate-pulse rounded-3xl p-7 flex-1 flex flex-col justify-between min-h-[220px]">
                    <div>
                        <div class="h-6 w-48 bg-[#333] rounded mb-4"></div>
                        <div class="h-10 w-3/4 bg-[#333] rounded-lg mb-2"></div>
                        <div class="h-10 w-1/2 bg-[#333] rounded-lg"></div>
                    </div>
                    <div class="h-10 w-40 bg-[#333] rounded-full mt-4"></div>
                </div>

                {{-- Skeleton 3 Horizontal Cards --}}
                <div class="flex gap-4 overflow-hidden pb-2 lg:pb-0">
                    @for($i = 0; $i < 3; $i++)
                        <div class="bg-[#202020] animate-pulse rounded-3xl p-5 w-36 shrink-0 flex flex-col justify-between min-h-[140px]">
                            <div class="h-3 w-4 bg-[#333] rounded mb-1"></div>
                            <div class="mt-auto">
                                <div class="h-8 w-12 bg-[#333] rounded-lg mb-2"></div>
                                <div class="h-3 w-16 bg-[#333] rounded mb-1"></div>
                                <div class="h-3 w-20 bg-[#333] rounded"></div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- SKELETON SECTION 2: MAIN GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-4">
                {{-- Kiri: Tugas --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex justify-between items-end mb-6 animate-pulse">
                        <div>
                            <div class="h-4 w-20 bg-[#2A2A2A] rounded mb-2"></div>
                            <div class="h-8 w-40 bg-[#2A2A2A] rounded"></div>
                        </div>
                        <div class="h-2 w-1/2 bg-[#2A2A2A] rounded-full"></div>
                    </div>
                    
                    <div class="space-y-4">
                        @for($i = 0; $i < 4; $i++)
                            <div class="flex items-center gap-4 p-3 rounded-2xl animate-pulse">
                                <div class="w-12 h-12 rounded-full bg-[#2A2A2A] shrink-0"></div>
                                <div class="flex-1">
                                    <div class="h-5 w-1/2 bg-[#2A2A2A] rounded mb-2"></div>
                                    <div class="h-3 w-1/3 bg-[#2A2A2A] rounded"></div>
                                </div>
                                <div class="h-4 w-16 bg-[#2A2A2A] rounded shrink-0"></div>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Kanan: Jadwal & Materi --}}
                <div class="space-y-8 animate-pulse">
                    <div>
                        <div class="flex justify-between mb-4">
                            <div class="h-6 w-32 bg-[#2A2A2A] rounded"></div>
                            <div class="h-4 w-16 bg-[#2A2A2A] rounded"></div>
                        </div>
                        <div class="bg-[#202020] rounded-3xl p-5 h-32"></div>
                    </div>
                    
                    <div>
                        <div class="h-6 w-36 bg-[#2A2A2A] rounded mb-4"></div>
                        <div class="space-y-3">
                            @for($i = 0; $i < 3; $i++)
                                <div class="bg-[#202020] rounded-2xl p-4 h-16"></div>
                            @endfor
                        </div>
                    </div>

                    <div class="bg-[#202020] rounded-xl p-6 h-36"></div>
                </div>
            </div>

        </div>


        {{-- ========================================== --}}
        {{-- 2. KONTEN ASLI (Tampil setelah loading selesai) --}}
        {{-- ========================================== --}}
        <div x-show="!isLoading" style="display: none;" class="space-y-8 transition-opacity duration-500">
            
            {{-- SECTION 1: HERO & CARDS (Bento Box Style) --}}
            <div class="flex flex-col lg:flex-row gap-4">
                
                {{-- Hero Banner (Coklat Gelap) --}}
                <div id="banner" class="bg-[#3E2119] rounded-3xl p-7 flex-1 flex flex-col justify-between min-h-[220px] relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="text-2xl text-[#F14D2D] mb-3 tracking-wide font-semibold">
                            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                        </div>
                        <p class="text-3xl md:text-4xl max-w-[400px] font-extrabold leading-tight mb-4 text-white">Halo, {{ explode(' ', auth()->user()->name)[0] }}! Kamu telah menyelesaikan {{ $completedTasks }} tugas sejauh ini</p>
                    </div>
                    <div class="relative z-10">
                        <flux:button href="{{ route('tasks.index') }}" class="!bg-[#F14D2D] !text-white !border-none !rounded-full !px-6 !py-2 hover:!bg-[#D13E22] transition font-bold">
                            Lihat Progress &nearr;
                        </flux:button>
                    </div>
                </div>

                {{-- 3 Horizontal Cards --}}
                <div id="horizontal-card" class="flex gap-4 overflow-x-auto hide-scrollbar pb-2 lg:pb-0">
                    
                    {{-- Card 1: Pending Tasks (Putih) --}}
                    <div class="bg-white text-black rounded-3xl p-5 w-36 shrink-0 flex flex-col justify-between relative overflow-hidden">
                        <span class="text-xs font-bold text-zinc-400 mb-1">01</span>
                        <div class="z-10 mt-auto">
                            <h3 class="font-extrabold text-3xl mb-1">{{ $pendingTasks }}</h3>
                            <p class="text-xs font-bold text-zinc-500 leading-tight">Tugas<br>Tertunda</p>
                        </div>
                    </div>

                    {{-- Card 2: Hari Ini (Orange) --}}
                    <div class="bg-[#F14D2D] text-white rounded-3xl p-5 w-36 shrink-0 flex flex-col justify-between relative overflow-hidden">
                        <span class="text-xs font-bold text-[#FFB6A8] mb-1">02</span>
                        <div class="z-10 mt-auto">
                            <h3 class="font-extrabold text-2xl mb-1 truncate">{{ $inProgressTask ?? 0 }}</h3>
                            <p class="text-xs font-bold text-[#FFD4CC] leading-tight">Tugas<br> Berlangsung</p>
                        </div>
                        {{-- Hiasan Garis Abstrak --}}
                        <div class="absolute -bottom-10 -right-10 w-24 h-24 border-4 border-[#C1381E] rounded-full opacity-50"></div>
                    </div>

                    {{-- Card 3: Tugas Selesai (Putih) --}}
                    <div class="bg-white text-black rounded-3xl p-5 w-36 shrink-0 flex flex-col justify-between relative overflow-hidden">
                        <span class="text-xs font-bold text-zinc-400 mb-1">03</span>
                        <div class="z-10 mt-auto">
                            <h3 class="font-extrabold text-3xl mb-1">{{ $completedTasks }}</h3>
                            <p class="text-xs font-bold text-zinc-500 leading-tight">Total<br>Selesai</p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- SECTION 2: MAIN GRID (Kiri: List Tugas, Kanan: Jadwal & Materi) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-4">
                
                {{-- KOLOM KIRI (Tugas Segera) --}}
                <div id="col-kiri" class="lg:col-span-2 space-y-6">
                    
                    {{-- Progress Header --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-6">
                        <div>
                            <p class="text-zinc-500 text-sm font-medium">Timeline</p>
                            <h2 class="text-2xl font-bold">Tugas Segera</h2>
                        </div>
                        
                        {{-- Progress Bar --}}
                        <div class="flex items-center gap-3 w-full sm:w-1/2">
                            <div class="h-1.5 w-full bg-[#2A2A2A] rounded-full overflow-hidden flex">
                                <div class="h-full bg-[#F14D2D] rounded-full transition-all duration-1000" style="width: {{ $taskProgress }}%"></div>
                            </div>
                            <span class="text-sm font-bold text-zinc-400">{{ $taskProgress }}%</span>
                        </div>
                    </div>

                    {{-- Task List --}}
                    <div class="space-y-4">
                        @forelse($upcomingTasks as $task)
                            @php
                                $daysLeft = \Carbon\Carbon::now()->diffInDays($task->due_date, false);
                                $isUrgent = $daysLeft <= 1;
                            @endphp
                            <a href="{{ route('tasks.show', $task->id) }}" class="block">
                            <div class="flex items-center gap-4 group cursor-pointer hover:bg-[#202020] p-3 rounded-2xl transition-colors -mx-3">
                                
                                {{-- Icon --}}
                                <div class="w-12 h-12 rounded-full bg-[#202020] border border-[#303030] flex items-center justify-center {{ $isUrgent ? 'text-[#F14D2D]' : 'text-zinc-400' }} group-hover:bg-[#F14D2D] group-hover:text-white transition-colors shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                                    </svg>
                                </div>
                                
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-sm text-white truncate">{{ $task->title }}</h4>
                                    <p class="text-xs text-zinc-500 truncate mt-0.5">{{ $task->subject->name }}</p>
                                </div>
                                
                                {{-- Meta --}}
                                <div class="text-right shrink-0">
                                    <p class="text-xs font-medium {{ $isUrgent ? 'text-[#F14D2D]' : 'text-zinc-500' }}">
                                        {{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            </a>
                        @empty
                            <div class="text-center py-10 bg-[#202020] rounded-2xl border border-[#303030] border-dashed">
                                <p class="text-zinc-500 text-sm">Tidak ada tugas mendesak. Aman! ☕</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- KOLOM KANAN (Jadwal & Materi) --}}
                <div id="col-kanan" class="space-y-8">
                    
                    {{-- Jadwal Terdekat --}}
                    <section>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Jadwal Kuliah</h2>
                            <a href="{{ route('schedules.index') }}" class="text-xs text-zinc-500 hover:text-white transition">Lihat semua</a>
                        </div>

                        @if($nextClass)
                            @php
                                $isNow = \Carbon\Carbon::now()->between($nextClass->start_time, $nextClass->end_time);
                            @endphp
                            <div class="bg-[#2A2A2A] rounded-3xl p-5 border border-[#3A3A3A]">
                                <h3 class="font-bold text-lg mb-1">{{ $nextClass->name }}</h3>
                                <p class="text-xs text-zinc-400 mb-5">
                                    {{ \Carbon\Carbon::parse($nextClass->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($nextClass->end_time)->format('H:i') }}
                                </p>
                                
                                <div class="flex justify-between items-center">
                                    <div class="bg-[#1A1A1A] rounded-full px-3 py-1.5 text-[10px] font-bold text-zinc-300 flex items-center gap-2 border border-[#333]">
                                        @if($isNow)
                                            <span class="w-2 h-2 rounded-full bg-[#F14D2D] animate-pulse"></span>
                                            Sedang Berlangsung
                                        @else
                                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $nextClass->color }}"></span>
                                            Ruang {{ $nextClass->room }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-[#202020] rounded-2xl p-4 border border-[#2A2A2A] text-center">
                                <p class="text-xs text-zinc-500">Tidak ada jadwal tersisa hari ini.</p>
                            </div>
                        @endif
                    </section>

                    {{-- Materi Terbaru --}}
                    <section>
                        <h2 class="text-xl font-bold mb-4">Materi Terbaru</h2>
                        <div class="space-y-3">
                            @forelse($recentMaterials as $material)
                                <a href="{{ route('materials.show', $material->subject_id) }}" class="block bg-[#202020] rounded-2xl p-4 border border-[#2A2A2A] hover:border-[#444] transition group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full" style="background-color: {{ $material->subject->color }}"></div>
                                        <div>
                                            <h3 class="font-bold text-sm text-white group-hover:text-[#F14D2D] transition-colors">{{ $material->title }}</h3>
                                            <p class="text-xs text-zinc-500 mt-0.5">{{ $material->subject->name }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <p class="text-xs text-zinc-500">Belum ada materi dibagikan.</p>
                            @endforelse
                        </div>
                    </section>

                    <section>
                        <div class="bg-[#F14D2D] rounded-xl p-6 text-white relative overflow-hidden">
                    {{-- Hiasan Background --}}
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/25 rounded-full blur-2xl"></div>     
                            <h3 class="font-bold text-lg mb-2 relative z-10">Ada Tugas Baru?</h3>
                            <p class="text-indigo-100 text-sm mb-4 relative z-10">Jangan tunda, catat sekarang agar tidak lupa.</p>    
                            <flux:button href=" {{ route('tasks.create') }} " variant="primary" class="w-full text-[#2a428c] font-bold py-2 rounded-lg text-sm hover:bg-indigo-50 transition relative z-10">
                                + Tambah Tugas
                            </flux:button>
                                    
                        </div>
                    </section>

                </div>
            </div>
            
        </div>
        
    </div>

</div>

</x-app-layout>


