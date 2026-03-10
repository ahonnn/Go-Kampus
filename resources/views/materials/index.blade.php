<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">

    {{-- 🌟 INISIALISASI ALPINE.JS --}}
    <div x-data="{ isLoading: true }" x-init="setTimeout(() => isLoading = false, 600)">

        {{-- ========================================== --}}
        {{-- 1. BAGIAN SKELETON (Tampil saat memuat) --}}
        {{-- ========================================== --}}
        <div x-show="isLoading" class="animate-pulse">
            
            {{-- Skeleton Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <div class="h-8 w-48 bg-[#2A2A2A] rounded-md mb-3"></div>
                    <div class="h-4 w-72 bg-[#2A2A2A] rounded-md"></div>
                </div>
                {{-- Skeleton Tombol Upload --}}
                <div class="h-10 w-36 bg-[#2A2A2A] rounded-lg"></div>
            </div>

            {{-- Skeleton Grid Folder --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                {{-- Membuat 8 kotak dummy agar terlihat penuh di layar --}}
                @for($i = 0; $i < 8; $i++)
                    <div class="bg-[#121212] border border-zinc-800 rounded-xl p-6 flex flex-col items-center justify-center min-h-[160px]">
                        {{-- Skeleton Icon Folder --}}
                        <div class="w-16 h-16 bg-[#2A2A2A] rounded-xl mb-4"></div>
                        
                        {{-- Skeleton Judul Matkul --}}
                        <div class="h-5 w-3/4 bg-[#2A2A2A] rounded mb-2"></div>
                        
                        {{-- Skeleton Jumlah Materi --}}
                        <div class="h-3 w-1/2 bg-[#2A2A2A] rounded"></div>
                    </div>
                @endfor
            </div>

        </div>

        {{-- ========================================== --}}
        {{-- 2. KONTEN ASLI (Tampil setelah loading selesai) --}}
        {{-- ========================================== --}}
        <div x-show="!isLoading" style="display: none;" class="transition-opacity duration-500">
            
            <div id="title-material" class="flex justify-between items-center mb-8">
                <div>
                    <flux:heading size="xl">Materi Kuliah</flux:heading>
                    <flux:subheading>Pilih mata kuliah untuk melihat file materi.</flux:subheading>
                </div>
                {{-- Tombol Upload Global --}}
                <flux:modal.trigger name="create-material">
                    <flux:button variant="primary" icon="plus">Upload Materi</flux:button>
                </flux:modal.trigger>
            </div>

            {{-- GRID FOLDER --}}
            <div id="card-material" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($subjects as $subject)
                
                    <a href="{{ route('materials.show', $subject->id) }}" class="group relative block">
                        <div id="card-material"> 
                        <flux:card class="h-full bg-[#121212] hover:bg-zinc-50 dark:hover:bg-zinc-600/50 transition border-zinc-200 dark:border-gray-700 hover:border-gray-400 dark:hover:border-gray-500">
                            
                            {{-- Icon Folder Besar --}}
                            <div class="flex items-center justify-center mb-4 text-zinc-300 group-hover:text-amber-400 transition-colors duration-500">
                                <flux:icon.folder class="w-16 h-16 fill-current" />
                            </div>

                            {{-- Nama & Info --}}
                            <div class="text-center">
                                <h3 class="font-bold text-zinc-900 dark:text-white truncate">
                                    {{ $subject->name }}
                                </h3>
                                <p class="text-xs text-zinc-500 mt-1">
                                    {{ $subject->materials_count }} Materi
                                </p>
                            </div>

                            {{-- Garis Warna Matkul di Bawah --}}
                            {{-- <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-xl" style="background-color: {{ $subject->color }}"></div> --}}
                        </flux:card>
                        </div>
                    </a>
                    
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-zinc-500">Belum ada mata kuliah.</p>
                    </div>
                @endforelse
            </div>

        </div> {{-- Penutup Konten Asli --}}

    </div> {{-- Penutup Alpine.js --}}

    {{-- ===================================== --}}
    {{-- MODAL CREATE (Global / Di luar Loop & Loading) --}}
    {{-- ===================================== --}}
    <flux:modal name="create-material" class="w-[90%] mx-auto md:w-full md:min-w-[35rem]">
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <flux:heading size="lg">Upload Materi Baru</flux:heading>
            
            {{-- Pilih Matkul --}}
            <flux:select name="subject_id" label="Mata Kuliah" placeholder="Pilih Matkul..." required>
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </flux:select>

            <flux:input name="title" label="Judul Materi" placeholder="Contoh: Pertemuan 1 - Pengantar" required />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:select name="category" label="Kategori" required>
                    <option>Slide Pertemuan</option>
                    <option>E-Book</option>
                    <option>Tugas</option>
                    <option>Referensi</option>
                    <option>Lainnya</option>
                </flux:select>
                
                <flux:input name="description" label="Deskripsi (Opsional)" placeholder="Catatan singkat..." />
            </div>

            <div>
                <flux:label>Upload File</flux:label>
                <div class="mt-2 border-2 border-dashed border-zinc-300 dark:border-zinc-700 rounded-lg p-6 text-center hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                    <input type="file" name="files[]" multiple id="file-upload" class="hidden" onchange="document.getElementById('file-count').innerText = this.files.length + ' file dipilih'">
                    <label for="file-upload" class="cursor-pointer">
                        <flux:icon.cloud-arrow-up class="w-8 h-8 mx-auto text-zinc-400 mb-2" />
                        <span class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Klik untuk upload</span>
                        <span class="text-xs text-zinc-500 block mt-1">Bisa pilih banyak file sekaligus</span>
                    </label>
                    <p id="file-count" class="text-sm font-bold text-zinc-700 mt-2"></p>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <flux:modal.close><flux:button variant="ghost">Batal</flux:button></flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

</div>
</x-app-layout>