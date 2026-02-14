<x-app-layout>


    <div class="max-w-6xl mx-auto p-6 space-y-8">

        {{-- SECTION 1: WELCOME & STATS --}}
        <div>
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                        Halo, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-zinc-500 mt-1">Siap untuk produktif hari ini?</p>
                </div>
                <div class="text-right hidden md:block">
                    <p class="text-sm font-medium text-zinc-400">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Card SKS --}}
                <div class="p-5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex items-center gap-4">
                    <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg">
                        <flux:icon.academic-cap class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $totalSks }}</p>
                        <p class="text-xs text-zinc-500 font-medium uppercase tracking-wide">Total SKS</p>
                    </div>
                </div>

                {{-- Card Matkul --}}
                <div class="p-5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                        <flux:icon.book-open class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $totalSubjects }}</p>
                        <p class="text-xs text-zinc-500 font-medium uppercase tracking-wide">Mata Kuliah</p>
                    </div>
                </div>

                {{-- Card Task Progress --}}
                <div class="p-5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex flex-col justify-center gap-2">
                    <div class="flex justify-between text-sm font-medium">
                        <span class="text-zinc-500">Tugas Selesai</span>
                        <span class="text-green-600">{{ $taskProgress }}%</span>
                    </div>
                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-2.5">
                        <div class="bg-green-500 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $taskProgress }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI (UTAMA) --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- SECTION 2: UP NEXT (Jadwal) --}}
                <section>
                    <flux:heading size="lg" class="mb-4">Jadwal {{ $today }} Ini</flux:heading>
                    
                    @if($nextClass)
                        @php
                            $isNow = \Carbon\Carbon::now()->between($nextClass->start_time, $nextClass->end_time);
                        @endphp
                        <flux:card class="border-l-4" style="border-left-color: {{ $nextClass->color }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        @if($isNow)
                                            <span class="animate-pulse flex h-2.5 w-2.5 rounded-full bg-red-500"></span>
                                            <span class="text-xs font-bold text-red-500 uppercase tracking-wide">Sedang Berlangsung</span>
                                        @else
                                            <span class="text-xs font-bold text-indigo-500 uppercase tracking-wide">Selanjutnya</span>
                                        @endif
                                    </div>
                                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-1">{{ $nextClass->name }}</h2>
                                    <p class="text-zinc-500 flex items-center gap-2">
                                        <flux:icon.clock class="w-4 h-4" /> {{ \Carbon\Carbon::parse($nextClass->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($nextClass->end_time)->format('H:i') }}
                                        <span class="mx-1">•</span>
                                        <flux:icon.map-pin class="w-4 h-4" /> {{ $nextClass->room }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="bg-zinc-100 dark:bg-zinc-800 px-3 py-1 rounded-lg text-sm font-medium">
                                        {{ $nextClass->lecturer }}
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    @else
                        <div class="p-8 bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-dashed border-zinc-200 text-center">
                            <p class="text-zinc-500">Tidak ada jadwal kelas lagi hari ini.</p>
                        </div>
                    @endif
                </section>

                {{-- SECTION 3: DEADLINE WATCH --}}
                <section>
                    <div class="flex justify-between items-center mb-4">
                        <flux:heading size="lg">Tugas Segera</flux:heading>
                        <a href="{{ route('tasks.index') }}" class="text-sm hover:underline">Lihat Semua</a>
                    </div>

                    <div class="space-y-3">
                        @forelse($upcomingTasks as $task)
                            @php
                                $daysLeft = \Carbon\Carbon::now()->diffInDays($task->due_date, false);
                                $isUrgent = $daysLeft <= 1;
                            @endphp
                            <div class="flex items-center gap-4 p-4 rounded-xl border transition hover:shadow-sm {{ $isUrgent ? 'bg-red-50 border-red-100 dark:bg-red-900/10 dark:border-red-800' : 'bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800' }}">
                                
                                {{-- Icon Status --}}
                                <div class="shrink-0">
                                    @if($isUrgent)
                                        <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                            <flux:icon.exclamation-triangle class="w-5 h-5" />
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                            <flux:icon.calendar class="w-5 h-5" />
                                        </div>
                                    @endif
                                </div>

                                {{-- Info Task --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-zinc-900 dark:text-white truncate">{{ $task->title }}</h4>
                                    <p class="text-xs text-zinc-500 truncate">{{ $task->subject->name }}</p>
                                </div>

                                {{-- Deadline --}}
                                <div class="text-right shrink-0">
                                    <p class="text-sm font-bold {{ $isUrgent ? 'text-red-600' : 'text-zinc-700' }}">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M') }}
                                    </p>
                                    <p class="text-[10px] text-zinc-400">
                                        {{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500 italic">Tidak ada tugas mendesak. Aman!</p>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- KOLOM KANAN (SIDEBAR) --}}
            <div class="space-y-8">
                
                {{-- SECTION 4: RECENT MATERIALS --}}
                <section>
                    <flux:heading size="lg" class="mb-4">Materi Terbaru</flux:heading>
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse($recentMaterials as $material)
                            <a href="{{ route('materials.show', $material->subject_id) }}" class="block p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition group">
                                <div class="flex items-center gap-3">
                                    <div class="w-1 h-8 rounded-full" style="background-color: {{ $material->subject->color }}"></div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-sm font-bold text-zinc-900 dark:text-white truncate group-hover:text-indigo-600 transition">
                                            {{ $material->title }}
                                        </h5>
                                        <p class="text-sm text-zinc-500 truncate">{{ $material->subject->name }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-4 text-center">
                                <p class="text-sm text-zinc-500">Belum ada materi diupload.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- QUICK ACTION --}}
                <section>
                    <div class="bg-[#2a428c] rounded-xl p-6 text-white relative overflow-hidden">
                        {{-- Hiasan Background --}}
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        
                        <h3 class="font-bold text-lg mb-2 relative z-10">Ada Tugas Baru?</h3>
                        <p class="text-indigo-100 text-sm mb-4 relative z-10">Jangan tunda, catat sekarang agar tidak lupa.</p>
                        
                        
                            <flux:button href=" {{ route('tasks.create') }} " variant="primary" class="w-full text-[#2a428c] font-bold py-2 rounded-lg text-sm hover:bg-indigo-50 transition relative z-10">
                                + Tambah Tugas
                            </flux:button>
                        
                    </div>
                    
                    {{-- Kita perlu include Modal Create Task di sini agar tombol di atas jalan --}}
                    {{-- Anda bisa copy-paste modal create task dari file index task sebelumnya --}}
                    {{-- Atau buat partial view: @include('tasks.partials.create-modal') --}}
                </section>

            </div>
        </div>
    </div>

</x-app-layout>


