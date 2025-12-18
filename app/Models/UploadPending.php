<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadPending extends Model
{
    protected $table = 'uploads_pending';

    protected $fillable = [
        'temp_path',
        'original_name',
        'final_path',
        'affaire_slug',
        'status',
        'error',
    ];
}
