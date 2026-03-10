<link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<x-app-layout>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
{{-- 🌟 PINDAHKAN INISIALISASI ALPINE.JS KE PALING ATAS SINI --}}
<div x-data="{ isLoading: true }" x-init="setTimeout(() => isLoading = false, 600)">

    {{-- ========================================== --}}
    {{-- 1. SKELETON HEADER & FILTER (Tampil saat memuat) --}}
    {{-- ========================================== --}}
    <div x-show="isLoading" class="animate-pulse">
        
        {{-- Skeleton Header & Tombol --}}
        <div class="flex justify-between items-center mb-6">
            <div class="h-8 w-32 bg-[#2A2A2A] rounded-md"></div>
            <div class="h-10 w-36 bg-[#2A2A2A] rounded-lg"></div>
        </div>

        {{-- Skeleton Navbar (Status) --}}
        <div class="mb-6 flex gap-6 border-b border-zinc-800 pb-3 overflow-hidden">
            <div class="h-5 w-16 bg-[#2A2A2A] rounded"></div>
            <div class="h-5 w-24 bg-[#2A2A2A] rounded"></div>
            <div class="h-5 w-36 bg-[#2A2A2A] rounded"></div>
            <div class="h-5 w-16 bg-[#2A2A2A] rounded"></div>
        </div>

        {{-- Skeleton Form Filter (Search, Select, Button) --}}
        <div class="mb-6 flex flex-col md:flex-row gap-4">
            {{-- Skeleton Search --}}
            <div class="flex-1 h-[42px] bg-[#2A2A2A] rounded-lg"></div>
            {{-- Skeleton Subject --}}
            <div class="w-full md:w-48 h-[42px] bg-[#2A2A2A] rounded-lg"></div>
            {{-- Skeleton Type --}}
            <div class="w-full md:w-40 h-[42px] bg-[#2A2A2A] rounded-lg"></div>
            {{-- Skeleton Button Filter --}}
            <div class="w-full md:w-28 h-[42px] bg-[#2A2A2A] rounded-lg"></div>
        </div>

    </div>

    {{-- ========================================== --}}
    {{-- 2. KONTEN ASLI HEADER & FILTER (Tampil setelah loading) --}}
    {{-- ========================================== --}}
    <div x-show="!isLoading" style="display: none;" class="transition-opacity duration-500">
        
        <div id="title-task" class="flex justify-between items-center mb-6">
            <h1 class="font-semibold text-2xl">List Tugas</h1>
            <flux:button href="{{ route('tasks.create') }}" icon="plus">Buat Tugas</flux:button>
        </div>

        <div id="filter-task" class="mb-6">
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

            <div id="search-task" class="flex flex-col md:flex-row gap-4">
                
                {{-- 1. Search Bar --}}
                <div class="flex-1">
                    <flux:input name="search" icon="magnifying-glass" placeholder="Cari tugas..." value="{{ request('search') }}" />
                </div>

                {{-- 2. Filter Subject --}}
                <div class="w-full md:w-48">
                    <select name="subject_id" class="w-full bg-[#121212] dark:bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 appearance-none text-white" onchange="this.form.submit()">
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
                    <select name="type" class="w-full bg-[#121212] dark:bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 appearance-none text-white" onchange="this.form.submit()">
                        <option value="">Semua Tipe</option>
                        <option value="individual" {{ request('type') == 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="group" {{ request('type') == 'group' ? 'selected' : '' }}>Group</option>
                    </select>
                </div>

                {{-- 4. Tombol Submit --}}
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary" icon="funnel">Filter</flux:button>
                    
                    @if(request()->hasAny(['search', 'subject_id', 'type', 'status']))
                        <flux:button href="{{ route('tasks.index') }}" variant="ghost">Reset</flux:button>
                    @endif
                </div>

            </div>
        </form>
    </div>

                {{-- ========================================== --}}
                {{-- 1. SKELETON LOADING (Tampil saat memuat) --}}
                {{-- ========================================== --}}
                <div x-show="isLoading" class="grid grid-row gap-2 mt-6">
                    {{-- Kita buat 4 skeleton berderet ke bawah sebagai contoh --}}
                    @for($i = 0; $i < 4; $i++)
                        <div class="bg-[#121212] border border-zinc-800 p-5 rounded-2xl animate-pulse">
                            
                            {{-- Skeleton Waktu Pengerjaan --}}
                            <div class="h-6 w-32 bg-[#2A2A2A] rounded-full mb-3"></div>

                            {{-- Skeleton Judul Tugas --}}
                            <div class="h-6 w-3/4 bg-[#2A2A2A] rounded mb-2"></div>
                            
                            {{-- Skeleton Mata Kuliah --}}
                            <div class="h-4 w-1/2 bg-[#2A2A2A] rounded mb-6"></div>

                            {{-- Skeleton Baris Bawah (Priority, Status, Type, Ellipsis) --}}
                            <div class="flex items-center gap-2 mt-3 flex-wrap">
                                <div class="h-7 w-20 bg-[#2A2A2A] rounded-full"></div> {{-- Priority --}}
                                <div class="h-7 w-28 bg-[#2A2A2A] rounded-full"></div> {{-- Status --}}
                                <div class="h-7 w-16 bg-[#2A2A2A] rounded-full"></div> {{-- Type --}}
                                
                                {{-- Titik tiga di ujung kanan --}}
                                <div class="ml-auto w-8 h-8 bg-[#2A2A2A] rounded-md"></div>
                            </div>
                        </div>
                    @endfor
                </div>

                {{-- ========================================== --}}
                {{-- 2. KONTEN ASLI (Tampil setelah loading selesai) --}}
                {{-- ========================================== --}}
                <div x-show="!isLoading" style="display: none;" class="grid grid-row gap-2 mt-6 transition-opacity duration-500">
                    @forelse($tasks as $task)
                <div id="card-task" class="grid grid-row gap-2">
                        <div class="bg-[#121212] border border-zinc-800 p-5 rounded-2xl hover:bg-[#181818] transition-all group">
                            
                            {{-- Waktu --}}
                            <div class="flex items-center gap-2 w-fit text-zinc-400 text-[15px] font-medium bg-zinc-900/50 px-3 py-1 rounded-full border border-zinc-800">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $task->due_date->diffForHumans() }}</span>
                            </div>

                            {{-- Judul & Matkul --}}
                            <h3 class="mt-3 text-zinc-100 text-[20px] font-semibold mb-2 group-hover:text-white transition-colors"><a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a></h3>
                            <h3 class="text-zinc-100 text-[15px] font-semibold mb-6 group-hover:text-white transition-colors">{{ $task->subject->name }}</h3>
                            
                            {{-- ... (Semua logika PHP untuk warna badge tetap sama) ... --}}
                            @php
                                $priorityClasses = match($task->priority) {
                                    'High' => 'bg-red-950/30 text-red-500 border-red-900/50',
                                    'Medium' => 'bg-orange-950/30 text-orange-500 border-orange-900/50',
                                    'Low' => 'bg-emerald-950/30 text-emerald-500 border-emerald-900/50',
                                    default => 'bg-zinc-800/30 text-zinc-400 border-zinc-700/50',
                                };
                            @endphp

                            <div class="flex justify-between items-end mt-3 flex-wrap gap-2">
                                <div class="flex items-center flex-wrap gap-2">
                                    {{-- ... (Isi Dropdown Priority, Status, dan Type sama persis dengan punyamu) ... --}}
                                    
                                    <flux:dropdown>
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
                                        <button class="px-3 py-1 rounded-full text-xs font-bold border {{ $task->status_data['class'] }} flex items-center gap-1 hover:opacity-80 transition cursor-pointer">
                                            {{ $task->status_data['label'] }}
                                            <flux:icon.chevron-down class="size-3.75" />
                                        </button>
                                        <flux:menu>
                                            <form action="{{ route('tasks.update-status', $task->id) }}" method="POST">
                                                @csrf @method('PATCH') <input type="hidden" name="status" value="panding">
                                                <flux:menu.item type="submit" as="button" icon="clock">Menunggu</flux:menu.item>
                                            </form>
                                            <form action="{{ route('tasks.update-status', $task->id) }}" method="POST">
                                                @csrf @method('PATCH') <input type="hidden" name="status" value="in_progress">
                                                <flux:menu.item type="submit" as="button" icon="play-circle">Sedang Dikerjakan</flux:menu.item>
                                            </form>
                                            <form action="{{ route('tasks.update-status', $task->id) }}" method="POST">
                                                @csrf @method('PATCH') <input type="hidden" name="status" value="completed">
                                                <flux:menu.item type="submit" as="button" icon="check-circle">Selesai</flux:menu.item>
                                            </form>
                                        </flux:menu>
                                    </flux:dropdown>

                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $task->type_data['class'] }}">
                                        {{ $task->type_data['label'] }}
                                    </span>
                                </div>
                                
                                {{-- Tombol Ellipsis ditaruh paling kanan dengan ml-auto (margin-left auto) --}}
                                <div class="ml-auto">
                                    <flux:dropdown>
                                        <flux:button icon="ellipsis-horizontal" size="sm" variant="ghost" />
                                        <flux:menu>
                                            @if($task->user_id === auth()->id())
                                                <flux:menu.item href="{{ route('tasks.edit', $task->id) }}" icon="pencil-square">Edit</flux:menu.item>
                                                <flux:menu.separator />
                                                <flux:modal.trigger name="delete-task-{{ $task->id }}">
                                                    <flux:menu.item icon="trash" class="text-red-600 hover:bg-red-50" as="button">Hapus</flux:menu.item>
                                                </flux:modal.trigger>
                                            @else
                                                <flux:menu.item icon="eye" href="#" disabled>Hanya Lihat</flux:menu.item>
                                            @endif
                                        </flux:menu>
                                    </flux:dropdown>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Delete tetap didalam foreach tapi diluar div card --}}
                        <flux:modal name="delete-task-{{ $task->id }}" class="w-[95%] md:min-w-88">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Hapus Tugas?</flux:heading>
                                    <flux:subheading>Apakah Anda yakin ingin menghapus tugas ini?</flux:subheading>
                                </div>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close><flux:button variant="ghost">Batal</flux:button></flux:modal.close>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" variant="danger">Ya, Hapus</flux:button>
                                    </form>
                                </div>
                            </div>
                        </flux:modal>

                    @empty
                        <div class="p-10 text-center bg-[#121212] border border-zinc-800 rounded-2xl">
                            <p class="text-zinc-500">Tidak ada tugas yang ditemukan.</p>
                        </div>
                    @endforelse
                </div>

                </div>

                {{-- Pagination disembunyikan saat loading --}}
                <div x-show="!isLoading" style="display: none;" class="mt-6">
                    {{ $tasks->links() }} 
                </div>

            </div> {{-- Penutup Alpine Wrapper --}}

        </div>
    </div>
</div>

        </div>
    </div>



    
    
</x-app-layout>


<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>