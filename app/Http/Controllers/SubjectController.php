<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Smalot\PdfParser\Parser;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::where('user_id', auth()->id())
        // 1. SOLUSI PERFORMA: Hitung jumlah tugas & materi dalam 1 query saja
        ->withCount(['tasks', 'materials']) 
        
        ->orderBy('semester', 'desc')
        ->get() // Eksekusi query dulu jadi Collection
        
        // 2. SOLUSI URUTAN HARI: Sorting manual pakai PHP setelah data diambil
        ->sortBy(function($subject) {
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            return array_search($subject->day, $days);
        });

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20',
            'lecturer' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:50',
            'sks' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required',
            'end_time' => 'nullable|after:start_time',
            'color' => 'required',
        ]);

        // Tambahkan user_id manual
        $request->user()->subjects()->create($validated);

        return redirect()->route('subjects.index')->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        if ($subject->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lecturer' => 'nullable|string',
            'sks' => 'required|integer',
            'room' => 'nullable|string',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'nullable',
            'color' => 'required',
        ]);

        $subject->update($validated);

        return redirect()->back()->with('success', 'Perubahan disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        if ($subject->user_id !== auth()->id()) abort(403);
        
        $subject->delete();
        return redirect()->back()->with('success', 'Mata kuliah dihapus.');
    }

public function importKrs(Request $request)
{
    $request->validate([
        'krs_file' => 'required|mimes:pdf|max:2048',
    ]);

    try {
        $pdfParser = new Parser();
        $pdf = $pdfParser->parseFile($request->file('krs_file')->getPathname());
        $text = $pdf->getText();

        // REGEX FINAL (STRICT MODE)
        // Perubahan:
        // 1. (?:\n|^)(\d+) : Angka No harus di AWAL BARIS (Fix Header terbaca)
        // 2. (?=\n\d|\n\s*Jumlah|\n\s*Mahasiswa|\n\s*Catatan|\z) : Berhenti di footer (Fix Footer terbaca)
        
        $pattern = '/(?:\n|^)(\d+)\s+(.*?)\s+(\d+)\s+(\d+)\s*\/\s*([A-Z])\s+(Senin|Selasa|Rabu|Kamis|Jumat|Sabtu|Minggu)\s+(\d{2}[\.:]\d{2}-\d{2}[\.:]\d{2})([A-Z0-9]+)\s+(.*?)(?=\n\d|\n\s*Jumlah|\n\s*Mahasiswa|\n\s*Catatan|\z)/s';

        if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
            
            $count = 0;

            foreach ($matches as $m) {
                // $m[1] = No Urut
                $rawName = trim($m[2]);     // Nama Matkul
                $sks = trim($m[3]);         // SKS
                $semester = trim($m[4]);    // Semester
                $day = trim($m[6]);         // Hari
                $jamRaw = trim($m[7]);      // Jam
                $code = trim($m[8]);        // Kode Matkul
                $dosenRuang = trim($m[9]);  // Dosen & Ruang

                // 1. BERSIHKAN NAMA MATKUL
                $name = str_replace(["\n", "\r", "\t"], " ", $rawName);
                $name = preg_replace('/\s+/', ' ', $name);

                // 2. OLAH JAM
                $jamParts = explode('-', $jamRaw);
                $startTime = str_replace('.', ':', trim($jamParts[0]));
                $endTime = str_replace('.', ':', trim($jamParts[1]));

                // 3. PISAHKAN DOSEN & RUANG
                $lecturer = $dosenRuang;
                $room = "-";

                // Pisah by Tab (\t)
                if (strpos($dosenRuang, "\t") !== false) {
                    $parts = explode("\t", $dosenRuang);
                    $lecturer = trim($parts[0]);
                    $room = trim(end($parts));
                } 
                // Pisah by Keyword
                elseif (preg_match('/(TI-\d+|Lab-.+|Kelas.+)/', $dosenRuang, $roomMatch, PREG_OFFSET_CAPTURE)) {
                    $splitPos = $roomMatch[0][1];
                    $lecturer = trim(substr($dosenRuang, 0, $splitPos));
                    $room = trim(substr($dosenRuang, $splitPos));
                }

                // Bersihkan Ruang
                $room = str_replace(['Kelas ', 'Ruang'], '', $room);
                $room = trim($room);

                // 2. Deteksi Duplikat "A - A"
                // Logika: Pecah berdasarkan tanda strip. Jika bagian kiri & kanan sama, ambil satu saja.
                if (strpos($room, '-') !== false) {
                    // Pecah string, contoh: "TI-4 - TI-4" menjadi ["TI-4 ", " TI-4"]
                    $parts = explode('-', $room);
                    
                    // Bersihkan spasi di setiap bagian
                    $parts = array_map('trim', $parts);
                    
                    // Hapus elemen kosong (jika ada "TI-4 - ")
                    $parts = array_filter($parts);
                    
                    // Hapus Duplikat
                    $parts = array_unique($parts);
                    
                    // Gabungkan kembali
                    // Jika ["TI-4", "TI-4"] -> jadi "TI-4"
                    // Jika ["Gedung A", "Lantai 2"] -> jadi "Gedung A - Lantai 2"
                    $room = implode(' - ', $parts);
                }

                // 3. Bersihkan sisa karakter di pinggir
                $room = trim($room, " -");

                // 4. SIMPAN DATABASE
                Subject::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'code' => $code 
                    ],
                    [
                        'name' => $name,
                        'sks' => $sks,
                        'semester' => $semester,
                        'lecturer' => $lecturer,
                        'room' => $room,
                        'day' => $day,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'color' => $this->getRandomColor(),
                    ]
                );

                $count++;
            }

            return redirect()->back()->with('success', "Berhasil mengimport $count mata kuliah!");
        } else {
            return redirect()->back()->with('error', 'Tidak ada jadwal yang terbaca. Pastikan format PDF KRS sesuai.');
        }

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

// TAMBAHKAN INI DI BAGIAN BAWAH CLASS
    private function getRandomColor()
    {
        $colors = [
            '#EF4444', // Red
            '#F97316', // Orange
            '#F59E0B', // Amber
            '#10B981', // Emerald
            '#14B8A6', // Teal
            '#0EA5E9', // Sky
            '#6366F1', // Indigo
            '#8B5CF6', // Violet
            '#EC4899', // Pink
            '#64748B', // Slate
        ];

        return $colors[array_rand($colors)];
    }

}
