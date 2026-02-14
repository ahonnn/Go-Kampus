<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'code',
        'lecturer',
        'semester',
        'sks',
        'room',
        'day',
        'start_time',
        'end_time',
        'color',
    ];
    
    // Relasi: Mata kuliah milik satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Mata kuliah punya banyak Tugas
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // Relasi: Mata kuliah punya banyak Materi
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    // Helper untuk format jam di tampilan nanti
    public function getScheduleAttribute()
    {
        if (!$this->day) return 'Jadwal belum diatur';
        
        $start = \Carbon\Carbon::parse($this->start_time)->format('H:i');
        $end = $this->end_time ? \Carbon\Carbon::parse($this->end_time)->format('H:i') : '?';
        
        return "{$this->day}, {$start} - {$end}";
    }
}
