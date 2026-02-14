<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Material;
use App\Models\MaterialAttachment;
use Illuminate\Support\Facades\Storage;


class MaterialController extends Controller
{


    // TAMPILKAN MATERI BERDASARKAN MATKUL
    public function index()
    {
        // Kita hanya butuh list Subject dan jumlah materinya (withCount)
        // Tidak perlu load semua materi di sini biar ringan
        $subjects = Subject::where('user_id', auth()->id())
            ->withCount('materials') 
            ->orderBy('name', 'asc')
            ->get();

        return view('materials.index', compact('subjects'));
    }

    // HALAMAN DALAM (ISI FOLDER)
    public function show(Subject $subject)
    {
        // Pastikan subject ini milik user yang login
        if ($subject->user_id !== auth()->id()) {
            abort(403);
        }

        // Load materi milik subject ini saja
        $subject->load(['materials.attachments' => function($q) {
            $q->orderBy('created_at', 'desc');
        }]);

        return view('materials.show', compact('subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'title' => 'required|string|max:255',
            'category' => 'required',
            'files.*' => 'nullable|file|max:20480', // Max 20MB per file
        ]);

        $material = Material::create([
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
        ]);

        $this->handleUploads($request, $material);

        return redirect()->back()->with('success', 'Materi berhasil ditambahkan!');
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'files.*' => 'nullable|file|max:20480',
        ]);

        $material->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
        ]);

        // Jika ada file baru diupload saat edit, tambahkan (append)
        $this->handleUploads($request, $material);

        return redirect()->back()->with('success', 'Materi diperbarui!');
    }

    // HAPUS MATERI (BESERTA SEMUA FILENYA)
    public function destroy(Material $material)
    {
        // Hapus fisik file dulu
        foreach ($material->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }
        
        // Data di DB akan terhapus otomatis karena cascadeOnDelete (jika sudah di-set di migration)
        // Tapi untuk aman, kita delete manual record attachmentnya jika perlu, atau langsung material
        $material->delete();

        return redirect()->back()->with('success', 'Materi dihapus.');
    }

    // DOWNLOAD FILE
    public function download(MaterialAttachment $attachment)
    {
        if (Storage::disk('public')->exists($attachment->file_path)) {
            return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
        }
        abort(404, 'File tidak ditemukan.');
    }

    // HAPUS SATU FILE LAMPIRAN (FITUR DI MODAL EDIT)
    public function destroyAttachment(MaterialAttachment $attachment)
    {
        // Hapus fisik file
        Storage::disk('public')->delete($attachment->file_path);
        
        // Hapus record database
        $attachment->delete();

        return redirect()->back()->with('success', 'File lampiran dihapus.');
    }

    // HELPER: FUNGSI UPLOAD BERULANG
    private function handleUploads($request, $material)
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('materials', 'public');

                $material->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }
    }




}
