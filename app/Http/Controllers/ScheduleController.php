<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
        {
        // 1. SETTING LOCALE (PENTING!)
        // Paksa Carbon menggunakan Bahasa Indonesia agar outputnya 'Senin', bukan 'Monday'
        Carbon::setLocale('id'); 
        
        // Ambil nama hari sekarang (Format 'l' = full day name di PHP, translatedFormat support locale)
        $today = Carbon::now()->translatedFormat('l'); 

        // 2. JADWAL HARI INI
        $todayClasses = Subject::where('user_id', auth()->id()) // <--- WAJIB ADA: Filter punya user sendiri
            ->where('day', $today)
            ->withCount(['tasks' => function($q) {
                // (Opsional) Hitung tugas yang belum selesai untuk badge notifikasi
                $q->whereIn('status', ['Pending', 'In Progress']);
            }])
            ->orderBy('start_time', 'asc')
            ->get();

        // 3. JADWAL MINGGUAN
        $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        $weeklySchedule = Subject::where('user_id', auth()->id()) // <--- WAJIB ADA
            ->orderBy('start_time')
            ->get()
            ->groupBy('day')
            ->sortBy(function($item, $key) use ($daysOrder) {
                return array_search($key, $daysOrder);
            });

        return view('schedules.index', compact('todayClasses', 'weeklySchedule', 'today'));
    }
}
