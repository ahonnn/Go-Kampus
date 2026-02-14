<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">

        {{-- Header & Navigasi --}}
        <div class="mb-8">
            <flux:button href=" {{ route('materials.index') }} " class="mb-4" icon="arrow-long-left">Kembali</flux:button>

            
            <div class="flex justify-between items-end border-b border-zinc-200 dark:border-zinc-700 pb-4">
                <div class="flex items-center gap-3">
                    <!-- <div class="w-2 h-10 rounded-full" style="background-color: {{ $subject->color }}"></div> -->
                    <div>
                        <flux:heading size="xl">{{ $subject->name }}</flux:heading>
                        <flux:subheading>{{ $subject->lecturer ?? 'Dosen belum diatur' }} - {{ $subject->sks }} SKS</flux:subheading>
                    </div>
                </div>

                {{-- Tombol Tambah Materi (Khusus Matkul Ini) --}}
                {{-- Kita bisa bikin modal khusus yang subject_id nya otomatis terpilih, tapi pakai global juga tidak apa-apa --}}
            </div>
        </div>

        {{-- LIST MATERI --}}
        <div class="space-y-4">
            @forelse($subject->materials as $material)
                <flux:card class="p-5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition group">
                    {{-- ... Isinya SAMA PERSIS dengan bagian card di kode sebelumnya ... --}}
                    
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded border border-indigo-100">
                                    {{ $material->category }}
                                </span>
                                <span class="text-xs text-zinc-400">{{ $material->created_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="font-bold text-lg leading-tight">{{ $material->title }}</h3>
                            @if($material->description)
                                <p class="text-sm text-zinc-500 mt-1">{{ $material->description }}</p>
                            @endif
                        </div>

                        {{-- Menu Dropdown (Edit/Hapus) --}}
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                            <flux:dropdown>
                                <flux:button icon="ellipsis-horizontal" size="sm" variant="ghost" />
                                <flux:menu>
                                    <flux:modal.trigger name="edit-material-{{ $material->id }}">
                                        <flux:menu.item icon="pencil-square">Edit</flux:menu.item>
                                    </flux:modal.trigger>
                                    <flux:menu.separator />
                                    <flux:modal.trigger name="delete-material-{{ $material->id }}">
                                        <flux:menu.item icon="trash" class="text-red-600">Hapus</flux:menu.item>
                                    </flux:modal.trigger>
                                </flux:menu>
                            </flux:dropdown>
                        </div>
                    </div>

                    {{-- List Files --}}
                    @if($material->attachments->count() > 0)
                        <div class="space-y-2 mt-4 border-t border-zinc-100 dark:border-zinc-700/50 pt-3">
                            @foreach($material->attachments as $file)
                                <div class="flex items-center justify-between text-sm group/file">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <flux:icon.document class="w-4 h-4 text-zinc-400" />
                                        <span class="truncate text-zinc-600 dark:text-zinc-300">{{ $file->file_name }}</span>
                                    </div>
                                    <flux:button icon="arrow-down-tray" size="xs" href="{{ route('materials.download', $file->id) }}"></flux:button>
                                    <!-- <a href="{{ route('materials.download', $file->id) }}" class="text-xs font-medium text-indigo-600 hover:underline">Download</a> -->
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- MODAL EDIT & DELETE (COPY DARI SEBELUMNYA, MASUKKAN DI SINI) --}}
                    <flux:modal name="edit-material-{{ $material->id }}" class="w-[90%] mx-auto md:w-full md:min-w-[35rem]"> 
                        <form action="{{ route('materials.update', $material->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                                        @csrf @method('PUT')
                                        <flux:heading size="lg">Edit Materi</flux:heading>

                                        <flux:input name="title" label="Judul" value="{{ $material->title }}" />
                                        <div class="grid grid-cols-2 gap-4">
                                            <flux:select name="category" label="Kategori" value="{{ $material->category }}">
                                                <option>Slide Pertemuan</option><option>E-Book</option><option>Tugas</option><option>Referensi</option>
                                            </flux:select>
                                            <flux:input name="description" label="Deskripsi Singkat" value="{{ $material->description }}" />
                                        </div>

                                        {{-- FILE YANG SUDAH ADA (Bisa dihapus satu-satu) --}}
                                        @if($material->attachments->count() > 0)
                                            <div>
                                                <flux:label>File Saat Ini</flux:label>
                                                <div class="mt-2 border rounded-lg divide-y divide-zinc-200 dark:divide-zinc-700">
                                                    @foreach($material->attachments as $att)
                                                        <div class="flex justify-between items-center p-2 bg-zinc-50 dark:bg-zinc-800">
                                                            <span class="text-sm truncate max-w-[200px]">{{ $att->file_name }}</span>
                                                            
                                                            {{-- Tombol Hapus File Kecil --}}
                                                            {{-- Kita pakai Button type="submit" dengan formaction berbeda agar tidak perlu bikin form baru --}}
                                                            <button type="submit" 
                                                                    formaction="{{ route('materials.attachment.destroy', $att->id) }}" 
                                                                    name="_method" value="DELETE"
                                                                    class="text-xs text-red-500 hover:underline hover:text-red-600 px-2 py-1 rounded bg-red-50 hover:bg-red-100 transition">
                                                                Hapus File
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        {{-- UPLOAD FILE BARU --}}
                                        <div>
                                            <flux:label>Tambah File Baru (Opsional)</flux:label>
                                            <input type="file" name="files[]" multiple class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                                        </div>

                                        <div class="flex justify-end gap-2 mt-4">
                                            <flux:modal.close><flux:button variant="ghost">Batal</flux:button></flux:modal.close>
                                            <flux:button type="submit" variant="primary">Simpan Perubahan</flux:button>
                                        </div>
                                    </form>
                    </flux:modal>
                    <flux:modal name="delete-material-{{ $material->id }}"> 
                        <div class="space-y-6">
                                        <flux:heading size="lg">Hapus Materi?</flux:heading>
                                        <p class="text-sm text-zinc-500">Materi <strong>{{ $material->title }}</strong> dan {{ $material->attachments->count() }} file lampirannya akan dihapus permanen.</p>
                                        <div class="flex gap-2 justify-end">
                                            <flux:modal.close><flux:button variant="ghost">Batal</flux:button></flux:modal.close>
                                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <flux:button type="submit" variant="danger">Hapus</flux:button>
                                            </form>
                                        </div>
                                    </div>
                    </flux:modal>

                </flux:card>
            @empty
                <div class="text-center py-12 bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-dashed border-zinc-300">
                    <p class="text-zinc-500">Folder ini masih kosong.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>