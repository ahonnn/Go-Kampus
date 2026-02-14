<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Task;
use App\Models\Material;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');
        $userId = auth()->id();
        $today = Carbon::now()->translatedFormat('l');

        // 1. STATISTIK UTAMA
        $totalSks = Subject::where('user_id', $userId)->sum('sks');
        $totalSubjects = Subject::where('user_id', $userId)->count();
        
        $totalTasks = Task::where('user_id', $userId)->count();
        $completedTasks = Task::where('user_id', $userId)->where('status', 'Completed')->count();
        // Hindari division by zero
        $taskProgress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // 2. UP NEXT (Jadwal Selanjutnya Hari Ini)
        // Cari matkul hari ini yang jam mulainya > jam sekarang
        $nextClass = Subject::where('user_id', $userId)
            ->where('day', $today)
            ->where('end_time', '>', Carbon::now()->format('H:i')) // Yang belum berakhir
            ->orderBy('start_time', 'asc')
            ->first();

        // 3. DEADLINE WATCH (Tugas Belum Selesai Terdekat)
        $upcomingTasks = Task::with('subject')
            ->where('user_id', $userId)
            ->where('status', '!=', 'Completed')
            ->whereDate('due_date', '>=', Carbon::now())
            ->orderBy('due_date', 'asc')
            ->take(4) // Ambil 4 saja
            ->get();

        // 4. MATERI TERBARU (5 Terakhir)
        $recentMaterials = Material::with('subject')
            ->whereHas('subject', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSks', 'totalSubjects', 'taskProgress', 
            'nextClass', 'upcomingTasks', 'recentMaterials', 'today'
        ));
    }
}
