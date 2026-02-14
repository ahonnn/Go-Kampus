<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<x-app-layout>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="font-semibold text-2xl">Buat Tugas</h1>

            <div class="mt-4">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                    <flux:fieldset>
                        <div class="space-y-6">
                            <flux:input name="title" label="Judul" value="{{ old('title', $task->title) }}" />
                            
                            <flux:input name="description" label="Deskripsi" value="{{ old('description', $task->description) }}" />

                            <flux:select name="subject_id" label="Mata Kuliah">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $task->subject_id == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </flux:select> 

                            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                                <flux:select name="status" label="Status">
                                    <option value="panding" {{ $task->status == 'panding' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </flux:select>

                                <flux:select name="priority" label="Priority">
                                    <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                                    <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                </flux:select>

                                <flux:select name="type" label="Type">
                                    <option value="individual" {{ $task->type == 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="group" {{ $task->type == 'group' ? 'selected' : '' }}>Group</option>
                                </flux:select> 
                            
                                
                                <flux:input name="due_date" type="date" label="Deadline" value="{{ old('due_date', $task->due_date) }}" />
                            </div>

                            <div class="flex justify-end gap-2">
                                <flux:button href="{{ route('tasks.index') }}" icon="arrow-long-left">Batal</flux:button>
                                <flux:button type="submit" variant="primary" icon:trailing="inbox-arrow-down">Update Tugas</flux:button>
                            </div>
                        </div>
                    </flux:fieldset>
                </form>

            </div>

        </div>
    </div>

    
    
</x-app-layout>