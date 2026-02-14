<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<x-app-layout>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="font-semibold text-2xl">Buat Tugas</h1>

            <div class="mt-4">

            <div x-data="{ type: 'individual' }">
                <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <flux:fieldset>
                        <div class="space-y-6">
                            <flux:input name="title" label="Judul" placeholder="Masukkan Judul" />
                            <flux:input name="description" badge="Optional" label="Deskripsi" placeholder="Masukkan Deskripsi" class="" />
                            <flux:select name="subject_id" label="Mata Kuliah">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </flux:select> 
                            

                            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                            <flux:select name="status" label="Status">
                                    <option value="panding">Menunggu</option>
                                    <option value="in_progress">Sedang Dikerjakan</option>
                                    <option value="completed">Selesai</option>
                            </flux:select> 

                            <flux:select name="priority" label="Priority" class="appearance-none">
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                            </flux:select> 

                            <flux:select name="type" label="Type" x-model="type">
                                    <option value="individual">Individual</option>
                                    <option value="group">Group</option>
                            </flux:select>

                            {{-- 2. BAGIAN ANGGOTA KELOMPOK (Hanya muncul jika type == group) --}}
                            <div x-show="type === 'group'" x-transition class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                <flux:heading size="sm" class="mb-3">Pilih Anggota Kelompok</flux:heading>
                                
                                <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto">
                                    @foreach($users as $user)
                                        {{-- Jangan tampilkan diri sendiri --}}
                                        @if($user->id !== auth()->id())
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" 
                                                    name="members[]" 
                                                    value="{{ $user->id }}" 
                                                    id="user-{{ $user->id }}"
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                <label for="user-{{ $user->id }}" class="text-sm text-zinc-700 dark:text-zinc-300">
                                                    {{ $user->name }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <p class="text-xs text-zinc-500 mt-2">*Anda otomatis terdaftar sebagai ketua.</p>
                            </div>
                        
                            <flux:input name="due_date" type="date" label="Deadline" class="" />

                             <div class="mt-4">
                            <flux:input type="file" badge="Optional" name="attachments[]" multiple label="Lampiran" />
                                
                                <flux:subheading>Bisa upload lebih dari satu file.</flux:subheading>
                            </div>

                            </div>
                            <div class="flex justify-end">
                                <flux:button href=" {{ route('tasks.index') }} " class="mx-4" icon="arrow-long-left">Kembali</flux:button>
                                <flux:button type="submit" variant="primary" icon:trailing="inbox-arrow-down">Simpan Tugas</flux:button>
                            </div>
                        </div>
                    </flux:fieldset>
                </form>
                </div>

            </div>

        </div>
    </div>

    
    
</x-app-layout>