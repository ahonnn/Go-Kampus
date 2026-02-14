@php
                            // Logika penentuan warna berdasarkan tingkat prioritas
                            $priorityClasses = match($task->priority) {
                                'High' => 'bg-red-950/30 text-red-500 border-red-900/50',
                                'Medium' => 'bg-orange-950/30 text-orange-500 border-orange-900/50',
                                'Low' => 'bg-emerald-950/30 text-emerald-500 border-emerald-900/50',
                                default => 'bg-zinc-800/30 text-zinc-400 border-zinc-700/50',
                            };
                        @endphp

<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        
        {{-- Header: Tombol Kembali & Judul --}}
        <div class="mb-6">
            <flux:button href=" {{ route('tasks.index') }} " class="mb-4" icon="arrow-long-left">Kembali ke Daftar Tugas</flux:button>

            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $task->title }}</h1>
                    <p class="text-zinc-500 mt-1">{{ $task->subject->name }} • {{ $task->type == 'group' ? 'Kelompok' : 'Individu' }}</p>
                </div>
                
                {{-- Status Badge --}}
                <span class="px-4 py-1 rounded-full text-sm font-bold border {{ $task->status_data['class'] }}">
                    {{ $task->status_data['label'] }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Kolom Kiri: Detail Utama --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Deskripsi --}}
                <flux:card>
                    <flux:heading size="lg" class="mb-3">Deskripsi</flux:heading>
                    <p class="text-zinc-700 dark:text-zinc-300 whitespace-pre-line leading-relaxed">
                        {{ $task->description ?: 'Tidak ada deskripsi.' }}
                    </p>
                </flux:card>

                {{-- Lampiran File --}}
                <flux:card>
                    <flux:heading size="lg" class="mb-3">Lampiran File</flux:heading>
                    @if($task->attachments->count() > 0)
                        <ul class="space-y-2">
                            @foreach($task->attachments as $file)
                                <li class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                    <div class="flex items-center gap-3">
                                        <flux:icon.document class="w-5 h-5 text-indigo-500" />
                                        <span class="text-sm font-medium truncate max-w-[200px]">{{ $file->file_name }}</span>
                                    </div>
                                    <flux:button icon="arrow-down-tray" size="xs" href="{{ route('attachments.download', $file->id) }}"></flux:button>

                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-zinc-500 italic">Tidak ada file yang dilampirkan.</p>
                    @endif
                </flux:card>
            </div>

            {{-- Kolom Kanan: Sidebar Info --}}
            <div class="space-y-6">
                <flux:card>
                    <div class="space-y-4">
                        <div>
                            <flux:label>Deadline</flux:label>
                            <p class="font-semibold text-lg">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
                            <p class="text-xs text-zinc-500">{{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }}</p>
                        </div>

                        <hr class="border-zinc-200 dark:border-zinc-700">

                        <div>
                            <flux:label>Prioritas</flux:label>
                            <p class="font-medium">{{ $task->priority }}</p>
                            
                        </div>

                        {{-- Tampilkan Anggota jika Tipe Group --}}
                        @if($task->type === 'group')
                            <hr class="border-zinc-200 dark:border-zinc-700">
                            <div>
                                <flux:label>Anggota Tim</flux:label>
                                <div class="flex -space-x-2 mt-2">
                                    {{-- Foto Pembuat --}}
                                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name={{ $task->user->name }}" alt="{{ $task->user->name }}" title="Ketua: {{ $task->user->name }}">
                                    
                                    {{-- Foto Anggota --}}
                                    @foreach($task->members as $member)
                                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name={{ $member->name }}" alt="{{ $member->name }}" title="{{ $member->name }}">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </flux:card>
            </div>

        </div>
    </div>
</x-app-layout>