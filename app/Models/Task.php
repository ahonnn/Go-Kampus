<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'subject_id',
        'title',
        'description',
        'status',
        'priority',
        'type',
        'due_date',
    ];

    // Casting tipe data otomatis
    protected $casts = [
        'due_date' => 'datetime', // Penting agar bisa diformat tanggalnya
    ];

    // Relasi 1: Pemilik Tugas (Creator)
    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi 2: Anggota Kelompok (Many-to-Many)
    // Mengambil user lain yang dimasukkan ke tugas ini
    public function members() {
        return $this->belongsToMany(User::class, 'task_user');
    }

    // Relasi 3: File Lampiran
    public function attachments() {
        return $this->hasMany(TaskAttachment::class);
    }
    
    // Relasi: Tugas milik satu User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Tugas mungkin milik satu Subject (bisa null jika tugas pribadi)
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    // Custom Status
    public function getStatusDataAttribute() {
        return match($this->status){
                'panding' => [
                'label' => 'Panding',
                'class' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
            ],
                'in_progress' => [
                'label' => 'In Progress',
                'class' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
            ],
                'completed' => [
                    'label' => 'Completed',
                    'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            ],
                default => [
                    'label' => $this->status,
                    'class' => 'bg-zinc-500/10 text-zinc-400 border-zinc-500/20',
            ],
        };
    }

    public function getTypeDataAttribute() {
        return match($this->type){
                'individual' => [
                'label' => 'Individual',
                'class' => 'bg-gray-500/10 text-gray-400 border-gray-500/30',
            ],
                'group' => [
                'label' => 'Group',
                'class' => 'bg-blue-500/10 text-blue-400 border-blue-500/30',
            ],
                default => [
                    'label' => $this->type,
                    'class' => 'bg-zinc-500/10 text-zinc-400 border-zinc-500/30',
            ],
        };
    }

}
