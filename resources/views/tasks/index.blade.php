<link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<x-app-layout>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <h1 class="font-semibold text-2xl">List Tugas</h1>
                <flux:button href=" {{ route('tasks.create') }} " icon="plus">Buat Tugas</flux:button>
            </div>

            <div class="mb-6">
                <flux:navbar scrollable>
                    <flux:navbar.item href="{{ route('tasks.index', request()->except('status')) }}" 
                                    :current="!request('status')">
                        Semua
                    </flux:navbar.item>

                    <flux:navbar.item href="{{ request()->fullUrlWithQuery(['status' => 'panding']) }}" 
                                    :current="request('status') === 'panding'">
                        Menunggu
                    </flux:navbar.item>

                    <flux:navbar.item href="{{ request()->fullUrlWithQuery(['status' => 'in_progress']) }}" 
                                    :current="request('status') === 'in_progress'">
                        Sedang Dikerjakan
                    </flux:navbar.item>

                    <flux:navbar.item href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}" 
                                    :current="request('status') === 'completed'">
                        Selesai
                    </flux:navbar.item>
                </flux:navbar>
            </div>

            <form action="{{ route('tasks.index') }}" method="GET" class="mb-6">
                {{-- Input Tersembunyi untuk menjaga Status tetap aktif saat search --}}
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <div class="flex flex-col md:flex-row gap-4">
                    
                    {{-- 1. Search Bar (Mengambil porsi lebar paling banyak) --}}
                    <div class="flex-1">
                        <flux:input name="search" icon="magnifying-glass" placeholder="Cari tugas..." value="{{ request('search') }}" />
                    </div>

                    {{-- 2. Filter Subject --}}
                    <div class="w-full md:w-48">
                        <select name="subject_id" class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 appearance-none" onchange="this.form.submit()">
                            <option value="">Semua Matkul</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 3. Filter Type --}}
                    <div class="w-full md:w-40">
                        <select name="type" class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 appearance-none" onchange="this.form.submit()">
                            <option value="">Semua Tipe</option>
                            <option value="individual" {{ request('type') == 'individual' ? 'selected' : '' }}>Individual</option>
                            <option value="group" {{ request('type') == 'group' ? 'selected' : '' }}>Group</option>
                        </select>
                    </div>

                    {{-- 4. Tombol Submit (Opsional jika pakai onchange di select, tapi wajib untuk search) --}}
                    <div>
                        <flux:button type="submit" variant="primary" icon="funnel">Filter</flux:button>
                        
                        {{-- Tombol Reset (Jika ada filter aktif) --}}
                        @if(request()->hasAny(['search', 'subject_id', 'type', 'status']))
                            <flux:button href="{{ route('tasks.index') }}" variant="ghost" class="ml-2">Reset</flux:button>
                        @endif
                    </div>

                </div>
            </form>

            <div class="grid grid-row gap-2 mt-6">
                @foreach($tasks as $task )
                    <div class="bg-[#121212] border border-zinc-800 p-5 rounded-2xl hover:bg-[#181818] transition-all group">
                        
                        <div class="flex items-center gap-2 w-fit text-zinc-400 text-[15px] font-medium bg-zinc-900/50 px-3 py-1 rounded-full border border-zinc-800">
                            <i class="fa-regular fa-clock"></i>
                            <span>{{ $task->due_date->diffForHumans() }}</span>
                        </div>

                        <h3 class="mt-3 text-zinc-100 text-[20px] font-semibold mb-2 group-hover:text-white transition-colors"><a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a></h3>
                        <!-- <p>{{ $task->description }}</p> -->
                         
                        
                        <h3 class="text-zinc-100 text-[15px] font-semibold mb-6 group-hover:text-white transition-colors">{{ $task->subject->name }}</h3>
                         

                        @php
                            // Logika penentuan warna berdasarkan tingkat prioritas
                            $priorityClasses = match($task->priority) {
                                'High' => 'bg-red-950/30 text-red-500 border-red-900/50',
                                'Medium' => 'bg-orange-950/30 text-orange-500 border-orange-900/50',
                                'Low' => 'bg-emerald-950/30 text-emerald-500 border-emerald-900/50',
                                default => 'bg-zinc-800/30 text-zinc-400 border-zinc-700/50',
                            };
                        @endphp

                        @php
                            // Logika penentuan warna berdasarkan tingkat prioritas
                            $statusClasses = match($task->status) {
                                'panding' => 'bg-red-950/30 text-red-500 border-red-900/50',
                                'in_progress' => 'bg-orange-950/30 text-orange-500 border-orange-900/50',
                                'completed' => 'bg-emerald-950/30 text-emerald-500 border-emerald-900/50',
                                default => 'bg-zinc-800/30 text-zinc-400 border-zinc-700/50',
                            };
                        @endphp

                        @php
                        
                            // Definisikan label yang ingin ditampilkan ke user
                            $statusLabels = [
                                'panding'     => 'Panding',
                                'in_progress' => 'In Progress',
                                'completed'   => 'Completed',
                            ];

                            // Ambil label berdasarkan status, atau gunakan aslinya jika tidak ada di list
                            $displayLabel = $statusLabels[$task->status] ?? ucfirst($task->status);

                        @endphp


                        <div class="flex justify-between">

                            <div class="flex items-center mt-3 flex-wrap gap-2">


                        <flux:dropdown>
                        {{-- Trigger: Badge Priority --}}
                        <button class="px-3 py-1 rounded-full text-xs font-bold border {{ $priorityClasses }} flex items-center gap-1 hover:opacity-80 transition cursor-pointer">
                            {{ $task->priority }}
                            <flux:icon.chevron-down class="size-3.75" />
                        </button>

                        <flux:menu>
                            <flux:menu.item as="button" type="submit" form="priority-high-{{ $task->id }}">High</flux:menu.item>
                            <flux:menu.item as="button" type="submit" form="priority-medium-{{ $task->id }}">Medium</flux:menu.item>
                            <flux:menu.item as="button" type="submit" form="priority-low-{{ $task->id }}">Low</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>

                    {{-- Form Tersembunyi (Agar Dropdown Rapi) --}}
                    {{-- Tips: Kita taruh form di luar/bawah agar codingan menu di atas bersih --}}
                        <form id="priority-high-{{ $task->id }}" action="{{ route('tasks.update-priority', $task->id) }}" method="POST" class="hidden">
                            @csrf @method('PATCH') <input type="hidden" name="priority" value="High">
                        </form>
                        <form id="priority-medium-{{ $task->id }}" action="{{ route('tasks.update-priority', $task->id) }}" method="POST" class="hidden">
                            @csrf @method('PATCH') <input type="hidden" name="priority" value="Medium">
                        </form>
                        <form id="priority-low-{{ $task->id }}" action="{{ route('tasks.update-priority', $task->id) }}" method="POST" class="hidden">
                            @csrf @method('PATCH') <input type="hidden" name="priority" value="Low">
                        </form>
                            
                    
                            <flux:dropdown>
                            {{-- 1. TRIGGER (Langsung Button saja, tanpa pembungkus) --}}
                            {{-- Flux otomatis tahu ini adalah tombol pembukanya --}}
                            <button class="px-3 py-1 rounded-full text-xs font-bold border {{ $task->status_data['class'] }} flex items-center gap-1 hover:opacity-80 transition cursor-pointer">
                                {{ $task->status_data['label'] }}
                                {{-- Ikon panah bawah --}}
                                <flux:icon.chevron-down class="size-3.75" />

                            </button>

                            {{-- 2. MENU (Isinya tetap sama) --}}
                                <flux:menu>
                                    
                                    <form action="{{ route('tasks.update-status', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="panding">
                                        <flux:menu.item type="submit" as="button" icon="clock">
                                            Menunggu
                                        </flux:menu.item>
                                    </form>

                                    <form action="{{ route('tasks.update-status', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="in_progress">
                                        <flux:menu.item type="submit" as="button" icon="play-circle">
                                            Sedang Dikerjakan
                                        </flux:menu.item>
                                    </form>

                                    <form action="{{ route('tasks.update-status', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <flux:menu.item type="submit" as="button" icon="check-circle">
                                            Selesai
                                        </flux:menu.item>
                                    </form>

                                </flux:menu>
                        </flux:dropdown>

                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $task->type_data['class'] }}">
                                {{ $task->type_data['label'] }}
                            </span>

                            <p class="font-semibold text-[15px]">{{ $task->created_at?->diffForHumans() }}</p>
                         </div>

                         <flux:dropdown>
                            <flux:button icon="ellipsis-horizontal" size="sm" variant="ghost" />

                            <flux:menu>
                            @if($task->user_id === auth()->id())
                            <flux:menu.item href="{{ route('tasks.edit', $task->id) }}" icon="pencil-square">
                                Edit
                            </flux:menu.item>

                            <flux:menu.separator />

                            {{-- BAGIAN HAPUS: Hanya Trigger, JANGAN dibungkus Form --}}
                            <flux:modal.trigger name="delete-task-{{ $task->id }}">
                                <flux:menu.item icon="trash" class="text-red-600 hover:bg-red-50" as="button">
                                    Hapus
                                </flux:menu.item>
                            </flux:modal.trigger>
                            @else
                                {{-- OPSI UNTUK ANGGOTA (Opsional) --}}
                                {{-- Anda bisa menampilkan menu 'Lihat Detail' atau kosongkan saja --}}
                                <flux:menu.item icon="eye" href="#" disabled>
                                    Hanya Lihat (Anggota)
                                </flux:menu.item>
                            @endif
                        </flux:menu>
                        
                        </flux:dropdown>

                        </div>
                        
                    </div>

                        <flux:modal name="delete-task-{{ $task->id }}" class="w-[95%] md:min-w-88">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Hapus Tugas?</flux:heading>
                                <flux:subheading>
                                    Apakah Anda yakin ingin menghapus tugas ini? Tindakan ini tidak dapat dibatalkan.
                                </flux:subheading>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />

                                <flux:modal.close>
                                    <flux:button variant="ghost">Batal</flux:button>
                                </flux:modal.close>

                                {{-- FORM PINDAH KE SINI --}}
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <flux:button type="submit" variant="danger">
                                        Ya, Hapus
                                    </flux:button>
                                </form>
                            </div>
                        </div>
                    </flux:modal>

                @endforeach
            </div>
            <div class="mt-6">
                {{ $tasks->links() }} 
            </div>

        </div>
    </div>



    
    
</x-app-layout>


<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>