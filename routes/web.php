<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Task;
use Livewire\Volt\Volt;
use App\Http\Controllers\AttachmentController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

// Route::post('/register', function () {
//     return view('auth.register');
// })->name('register');

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function () {
    // Handle forgot password logic
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function () {
    return view('auth.reset-password');
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function () {
    // Handle reset password logic
})->middleware('guest')->name('password.update');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/logout', [ProfileController::class, 'destroy'])->name('logout');

Route::get('/auth-google-redirect', [GoogleController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth-google-callback', [GoogleController::class, 'callback'])
    ->name('google.callback');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Start Route Task
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');

    Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');

    // 1. Menampilkan Form Edit (Kita butuh ID tugas mana yang mau diedit: {task})
    Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    // 2. Memproses Update Data (Perhatikan methodnya PUT)
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    // 3. Menghapus Data (Perhatikan methodnya DELETE)
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    // 4. Update dari Halaman Index menggunakan dropdown
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::patch('/tasks/{task}/priority', [TaskController::class, 'updatePriority'])->name('tasks.update-priority');

    // Route Detail Tugas
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    // Route khusus download
    Route::get('/download/{attachment}', [TaskController::class, 'download'])->name('attachments.download');
    // End Route Task

    Route::prefix('materials')->name('materials.')->group(function () {
            Route::get('/', [MaterialController::class, 'index'])->name('index');
            Route::get('/folder/{subject}', [MaterialController::class, 'show'])->name('show');
            Route::post('/', [MaterialController::class, 'store'])->name('store');
            Route::put('/{material}', [MaterialController::class, 'update'])->name('update');
            Route::delete('/{material}', [MaterialController::class, 'destroy'])->name('destroy');
            
            // Download File
            Route::get('/download/{attachment}', [MaterialController::class, 'download'])->name('download');
            
            // Hapus Satu File Lampiran (Khusus saat Edit)
            Route::delete('/attachment/{attachment}', [MaterialController::class, 'destroyAttachment'])->name('attachment.destroy');
    });

    
    Route::get('subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('/subjects/import', [SubjectController::class, 'importKrs'])->name('subjects.import');

    Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');


    Route::resource('tasks', TaskController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('materials', MaterialController::class);

});



// --- GUEST ROUTES (Hanya bisa diakses jika BELUM login) ---
Route::middleware('guest')->group(function () {
    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- AUTH ROUTES (Hanya bisa diakses jika SUDAH login) ---
Route::middleware('auth')->group(function () {
    // Logout (Harus POST demi keamanan)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});