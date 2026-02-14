<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'title',
        'file_type',
        'file_path',
        'description',
    ];

    // --- TAMBAHKAN KODE INI ---
    public function subject()
    {
        // Relasi: Satu Materi dimiliki oleh Satu Mata Kuliah
        return $this->belongsTo(Subject::class);
    }

        public function attachments() {
            return $this->hasMany(MaterialAttachment::class);
    }
}
