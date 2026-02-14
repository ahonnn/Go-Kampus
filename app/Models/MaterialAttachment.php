<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialAttachment extends Model
{
    protected $fillable = [
        'material_id', 
        'file_name', 
        'file_path', 
        'file_type', 
        ];
}
