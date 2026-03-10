<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

    {{-- 🌟 INISIALISASI ALPINE.JS --}}
    {{-- Mengatur waktu loading selama 1 detik (1000ms) sebelum konten asli muncul --}}
    <div x-data="{ isLoading: true }" x-init="setTimeout(() => isLoading = false, 600)">

        {{-- ========================================== --}}
        {{-- 1. BAGIAN SKELETON (Tampil saat memuat) --}}
        {{-- ========================================== --}}
        <div x-show="isLoading" class="space-y-8 animate-pulse">
            
            {{-- Skeleton Header & Tombol --}}
            <div class="flex justify-between md:items-center mb-8 flex-col md:flex-row">
                <div>
                    {{-- Skeleton Judul "Mata Kuliah" --}}
                    <div class="h-8 w-48 bg-[#2A2A2A] rounded-md mb-3"></div>
                    {{-- Skeleton Subjudul --}}
                    <div class="h-4 w-72 bg-[#2A2A2A] rounded-md"></div>
                </div>

                <div class="flex gap-2 flex-col md:flex-row mt-5">
                    {{-- Skeleton Tombol Import & Tambah --}}
                    <div class="h-10 w-40 bg-[#2A2A2A] rounded-lg"></div>
                    <div class="h-10 w-40 bg-[#2A2A2A] rounded-lg"></div>
                </div>
            </div>

            {{-- Skeleton Grid Mata Kuliah --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Kita buat 6 kotak skeleton (dummy) agar layar terlihat penuh --}}
                @for($i = 0; $i < 6; $i++)
                    <div class="bg-[#121212] border border-zinc-800 rounded-xl p-6 relative overflow-hidden">
                        
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-full">
                                {{-- Skeleton Nama Matkul --}}
                                <div class="h-6 w-3/4 bg-[#2A2A2A] rounded mb-2"></div>
                                {{-- Skeleton SKS --}}
                                <div class="h-3 w-16 bg-[#2A2A2A] rounded"></div>
                            </div>
                            {{-- Skeleton Icon Titik Tiga --}}
                            <div class="h-8 w-8 bg-[#2A2A2A] rounded-md shrink-0 ml-4"></div>
                        </div>

                        {{-- Skeleton Info (Dosen, Jam, Ruangan) --}}
                        <div class="space-y-3 mt-6">
                            <div class="flex gap-2 items-center">
                                <div class="h-4 w-4 bg-[#2A2A2A] rounded-full"></div>
                                <div class="h-4 w-5/6 bg-[#2A2A2A] rounded"></div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <div class="h-4 w-4 bg-[#2A2A2A] rounded-full"></div>
                                <div class="h-4 w-2/3 bg-[#2A2A2A] rounded"></div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <div class="h-4 w-4 bg-[#2A2A2A] rounded-full"></div>
                                <div class="h-4 w-1/2 bg-[#2A2A2A] rounded"></div>
                            </div>
                        </div>

                    </div>
                @endfor
            </div>
        </div>


        {{-- ========================================== --}}
        {{-- 2. KONTEN ASLI (Tampil setelah loading selesai) --}}
        {{-- ========================================== --}}
        <div x-show="!isLoading" style="display: none;" class="transition-opacity duration-500">
            
            {{-- Header & Tombol Tambah --}}
            <div id="title-subject" class="flex justify-between md:items-center mb-8 flex-col md:flex-row">
                <div>
                    <flux:heading size="xl">Mata Kuliah</flux:heading>
                    <flux:subheading>Daftar mata kuliah yang Anda ambil semester ini.</flux:subheading>
                </div>

                <div class="flex gap-2 flex-col md:flex-row mt-5">
                    {{-- TOMBOL IMPORT --}}
                    <flux:modal.trigger name="import-krs">
                        <flux:button icon="document-arrow-up" variant="ghost">Import KRS (PDF)</flux:button>
                    </flux:modal.trigger>

                    {{-- TOMBOL MANUAL --}}
                    <flux:modal.trigger name="create-subject">
                        <flux:button variant="primary" icon="plus">Tambah Matkul</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>

            {{-- Grid Mata Kuliah --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($subjects as $subject)
                <div id="card-subject" class="grid gap-6">
                    <flux:card class="hover:border-zinc-300 dark:hover:border-zinc-600 bg-[#121212] transition relative overflow-hidden">
                        
                        {{-- Garis Warna di Kiri Card --}}
                        {{-- <div class="absolute left-0 top-0 bottom-0 w-1.5" style="background-color: {{ $subject->color }}"></div> --}}

                        <div class="pl-4"> {{-- Padding left agar tidak kena garis warna --}}
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-bold text-lg text-zinc-900 dark:text-white">{{ $subject->name }}</h3>
                                    <p class="text-xs text-zinc-500 font-normal">{{ $subject->sks }} SKS</p>
                                </div>
                                
                                {{-- Menu Titik Tiga (Edit/Hapus) --}}
                                <flux:dropdown>
                                    <flux:button icon="ellipsis-horizontal" size="sm" variant="ghost" />
                                    <flux:menu>
                                        <flux:modal.trigger name="edit-subject-{{ $subject->id }}">
                                            <flux:menu.item icon="pencil-square">Edit</flux:menu.item>
                                        </flux:modal.trigger>

                                        <flux:menu.separator />

                                        <flux:modal.trigger name="delete-subject-{{ $subject->id }}">
                                            <flux:menu.item icon="trash" class="text-red-600">Hapus</flux:menu.item>
                                        </flux:modal.trigger>
                                    </flux:menu>
                                </flux:dropdown>
                            </div>

                            {{-- Menampilkan Info Matkul --}}
                            <div class="space-y-2 mt-4">
                                <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                    <flux:icon.user class="w-4 h-4" />
                                    <span>{{ $subject->lecturer ?? 'Dosen belum diatur' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                    <flux:icon.clock class="w-4 h-4" />
                                    <span>{{ $subject->day }}, {{ \Carbon\Carbon::parse($subject->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($subject->end_time)->format('H:i') }}</span>
                                </div>
                                @if($subject->room)
                                    <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                        <flux:icon.map-pin class="w-4 h-4" />
                                        <span>{{ $subject->room }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- MODAL EDIT (Di dalam loop agar bisa akses ID $subject) --}}
                        <flux:modal name="edit-subject-{{ $subject->id }}" class="w-[95%] md:min-w-[30rem] overflow-hidden">
                            <form action="{{ route('subjects.update', $subject->id) }}" method="POST" class="space-y-4">
                                @csrf @method('PUT')
                                <flux:heading size="lg">Edit Mata Kuliah</flux:heading>
                                
                                <flux:input name="name" label="Nama Matkul" value="{{ $subject->name }}" />
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <flux:input name="lecturer" label="Dosen" value="{{ $subject->lecturer }}" />
                                    <flux:input name="sks" label="SKS" type="number" value="{{ $subject->sks }}" />
                                </div>

                                <flux:input name="room" label="Ruangan" value="{{ $subject->room }}" />

                                <div class="grid grid-cols-3 gap-4">
                                    <flux:select name="day" label="Hari" value="{{ $subject->day }}">
                                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endforeach
                                    </flux:select>
                                    <flux:input type="time" name="start_time" label="Mulai" value="{{ $subject->start_time }}" />
                                    <flux:input type="time" name="end_time" label="Selesai" value="{{ $subject->end_time }}" />
                                </div>

                                <div>
                                    <flux:label>Warna Label</flux:label>
                                    <div class="flex gap-4 mt-2 overflow-x-auto pb-2 py-2 px-2 w-full no-scrollbar">
                                        @foreach([
                                            '#EF4444', '#F97316', '#F59E0B', '#10B981', '#14B8A6', 
                                            '#0EA5E9', '#6366F1', '#8B5CF6', '#EC4899', '#64748B'
                                        ] as $color)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="color" value="{{ $color }}" class="peer sr-only" {{ $subject->color == $color ? 'checked' : '' }}>
                                                <div class="w-8 h-8 rounded-full border-2 border-transparent peer-checked:border-zinc-900 peer-checked:ring-2 ring-offset-2" style="background-color: {{ $color }}"></div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <flux:modal.close><flux:button variant="ghost">Batal</flux:button></flux:modal.close>
                                    <flux:button type="submit" variant="primary">Simpan</flux:button>
                                </div>
                            </form>
                        </flux:modal>

                        {{-- MODAL HAPUS --}}
                        <flux:modal name="delete-subject-{{ $subject->id }}" class="w-[95%]">
                            <div class="space-y-6">
                                <flux:heading size="lg">Hapus Mata Kuliah?</flux:heading>
                                <p class="text-sm text-zinc-500">
                                    Semua tugas yang berhubungan dengan mata kuliah <strong>{{ $subject->name }}</strong> juga akan terhapus.
                                </p>
                                <div class="flex gap-2 justify-end">
                                    <flux:modal.close><flux:button variant="ghost">Batal</flux:button></flux:modal.close>
                                    <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" variant="danger">Hapus</flux:button>
                                    </form>
                                </div>
                            </div>
                        </flux:modal>

                    </flux:card>
                </div>
                @endforeach
            </div>

        </div> {{-- Penutup Area Konten Asli --}}

    </div> {{-- Penutup Pembungkus Alpine.js --}}

    {{-- ========================================== --}}
    {{-- MODAL GLOBAL (Ditaruh paling luar agar aman) --}}
    {{-- ========================================== --}}

    {{-- MODAL CREATE --}}
    <flux:modal name="create-subject" class="w-[95%] md:min-w-[30rem] no-scrollbar">
        <form action="{{ route('subjects.store') }}" method="POST" class="space-y-4">
            @csrf
            <flux:heading size="lg">Tambah Mata Kuliah</flux:heading>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input name="name" label="Nama Matkul" placeholder="Contoh: Pemrograman Web" required />
                <flux:input name="code" label="Kode" placeholder="TIF101" />
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input name="lecturer" label="Dosen Pengampu" />
                <flux:input name="room" label="Ruangan" placeholder="Gedung B" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <flux:input name="sks" label="SKS" type="number" value="2" />
                <flux:input name="semester" label="Semester" type="number" value="1" />
                <flux:select name="day" label="Hari">
                    <option>Senin</option><option>Selasa</option><option>Rabu</option>
                    <option>Kamis</option><option>Jumat</option><option>Sabtu</option>
                </flux:select>
            </div>

            <div class="grid grid-cols-2 gap-4 md:col-span-2 md:grid-cols-2">
                <flux:input type="time" name="start_time" label="Jam Mulai" required />
                <flux:input type="time" name="end_time" label="Jam Selesai" />
            </div>

            <div>
                <flux:label>Warna Label</flux:label>
                <div class="flex gap-4 mt-2 overflow-x-auto pb-2 py-2 px-2 w-full no-scrollbar">
                    @foreach([
                        '#EF4444', '#F97316', '#F59E0B', '#10B981', '#14B8A6', 
                        '#0EA5E9', '#6366F1', '#8B5CF6', '#EC4899', '#64748B'
                    ] as $c)
                        <label class="cursor-pointer shrink-0 group relative">
                            <input type="radio" name="color" value="{{ $c }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                            <div class="w-8 h-8 rounded-full border-2 border-transparent peer-checked:border-zinc-900 peer-checked:ring-2 ring-offset-2" style="background-color: {{ $c }}"></div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- MODAL IMPORT KRS --}}
    <flux:modal name="import-krs" class="w-[95%] md:w-full md:min-w-[30rem]">
        <form action="{{ route('subjects.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <flux:heading size="lg">Import KRS Otomatis</flux:heading>
                <flux:subheading>Upload file PDF KRS dari portal akademik Anda.</flux:subheading>
            </div>

            <div class="p-6 border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition text-center cursor-pointer relative">
                <input type="file" name="krs_file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                
                <flux:icon.document-text class="w-12 h-12 text-zinc-300 mx-auto mb-3" />
                <p class="text-sm font-medium text-zinc-900 dark:text-white">Klik untuk upload file PDF</p>
                <p class="text-xs text-zinc-500 mt-1">Maksimal ukuran 2MB</p>
            </div>

            <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg flex gap-3 items-start">
                <flux:icon.information-circle class="w-5 h-5 text-indigo-600 mt-0.5 shrink-0" />
                <div class="text-sm text-indigo-900 dark:text-indigo-200">
                    <p class="font-bold mb-1">Catatan Penting:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        <li>Pastikan file adalah <strong>PDF Asli</strong> (bukan hasil scan foto).</li>
                        <li>Sistem akan otomatis membaca: Nama Matkul, Dosen, Ruang, Hari, dan Jam.</li>
                        <li>Jika ada yang salah, Anda bisa mengeditnya manual nanti.</li>
                    </ul>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <flux:modal.close><flux:button variant="ghost">Batal</flux:button></flux:modal.close>
                <flux:button type="submit" variant="primary">Proses Import</flux:button>
            </div>
        </form>
    </flux:modal>

</div>
</x-app-layout>