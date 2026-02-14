<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskAttachment;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $tasks = auth()->user()->tasks()->with('subject')->latest()->get();

        $userId = auth()->id();

    // PERBAIKAN 1: Hanya ambil subject milik user sendiri, urutkan nama biar rapi di dropdown
    $subjects = \App\Models\Subject::where('user_id', $userId)
        ->orderBy('name', 'asc')
        ->get();
    
    $tasks = \App\Models\Task::with(['subject', 'members']) // PERBAIKAN 2: Load members sekalian
        // LOGIKA DASAR (User & Group)
        ->where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('members', function($q) use ($userId) {
                      $q->where('task_user.user_id', $userId);
                  });
        })
        // FILTER 1: Pencarian (Search)
        ->when($request->search, function ($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  // Bonus: Bisa cari berdasarkan nama matkul juga
                  ->orWhereHas('subject', function($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%");
                  });
            });
        })
        // FILTER 2: Mata Kuliah
        ->when($request->subject_id, function ($query, $subjectId) {
            $query->where('subject_id', $subjectId);
        })
        // FILTER 3: Tipe
        ->when($request->type, function ($query, $type) {
            $query->where('type', $type);
        })
        // FILTER 4: Status
        ->when($request->status, function ($query, $status) {
            $query->where('status', $status);
        })
        // Sorting: Prioritaskan deadline terdekat, tapi yang belum selesai dulu
        ->orderByRaw("FIELD(status, 'Pending', 'In Progress', 'Completed')") 
        ->orderBy('due_date', 'asc') 
        
        // PERBAIKAN 3: Gunakan Paginate agar halaman tidak berat
        ->paginate(10)
        ->withQueryString(); // Agar saat pindah halaman, filter tidak hilang

    return view('tasks.index', compact('tasks', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = auth()->user()->subjects;
        $users = User::all();

        // return view('tasks.create', compact('subjects'));
        return view('tasks.create', [
        'subjects' => $subjects,
        'users' => $users // <--- INI YANG DIMAKSUD
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'status' => 'required',
            'priority' => 'required',
            'due_date' => 'required|date',
        ]);

        // 2. Buat Tugas Utama
        $task = auth()->user()->tasks()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'subject_id'  => $request->subject_id,
            'status'  => $request->status,
            'type'        => $request->type,
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
        ]);

        // 3. Jika Tipe Kelompok, Simpan Anggotanya
        if ($request->type === 'group' && $request->has('members')) {
            // attach() digunakan untuk mengisi tabel pivot (task_user)
            $task->members()->attach($request->members);
        }

        // 4. Jika Ada File Lampiran, Upload & Simpan
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Upload ke folder 'task_files' di storage public
                $path = $file->store('task_files', 'public');

                // Simpan info file ke database
                $task->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }


        // Cek apakah $task berhasil dibuat
    if($task) {
        return redirect()->route('tasks.index');
    } else {
        dd("Gagal menyimpan ke database");
    }
    }



    /**
     * Display the specified resource.
     */

    public function show(Task $task)
    {
        // Keamanan: Cek apakah user berhak melihat tugas ini
        // Logikanya: Pembuat tugas ATAU Anggota kelompok
        $isMember = $task->members->contains(auth()->id());
        
        if ($task->user_id !== auth()->id() && !$isMember) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        // Load relasi agar efisien
        $task->load(['attachments', 'members', 'subject']);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        // KEAMANAN: Pastikan task ini milik user yang login
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $subjects = auth()->user()->subjects;
        $users = \App\Models\User::all();
        return view('tasks.edit', compact('task', 'subjects'));
    }

    public function update(Request $request, Task $task)
    {
        // KEAMANAN
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        // dd($request->all());

        // 1. Validasi (Sama seperti store)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'status' => 'required',
            'priority' => 'required',
            'due_date' => 'required|date',
            // ... validasi lain sesuai kebutuhan
        ]);

        // 2. Update Data
        // Kita tidak pakai create(), tapi update() langsung pada object $task
        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'subject_id'  => $request->subject_id,
            'status'      => $request->status,
            'priority'    => $request->priority,
            'type'        => $request->type,
            'description'    => $request->due_date,
        ]);

        // 3. Redirect
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Task $task)
    {
        // KEAMANAN
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }

    // Method khusus untuk update status saja via Dropdown
    public function updateStatus(Request $request, Task $task)
    {
        // 1. Validasi hanya status
        $request->validate([
            'status' => 'required|in:panding,in_progress,completed',
        ]);

        // 2. Update hanya kolom status
        $task->update([
            'status' => $request->status,
        ]);

        // 3. Kembali ke halaman index dengan pesan
        return redirect()->back()->with('success', 'Status tugas berhasil diperbarui!');
    }

    public function updatePriority(Request $request, Task $task)
    {
        // 1. Validasi hanya status
        $request->validate([
            'priority' => 'required|in:High,Medium,Low',
        ]);

        // 2. Update hanya kolom status
        $task->update([
            'priority' => $request->priority,
        ]);

        // 3. Kembali ke halaman index dengan pesan
        return redirect()->back()->with('success', 'Priority tugas berhasil diperbarui!');
    }

    public function download(TaskAttachment $attachment)
    {
        // Cek apakah file fisik benar-benar ada di storage
        // 'public' adalah nama disk yang kita pakai saat upload
        if (!Storage::disk('public')->exists($attachment->file_path)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        // Force Download: Browser akan dipaksa download, bukan preview
        return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
    }


    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
}


