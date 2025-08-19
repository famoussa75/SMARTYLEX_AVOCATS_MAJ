<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courierLiers extends Model
{
    protected $primaryKey = 'idCourierLier';
    protected $fillable = [

        'slugCourierLier',
        'cleCommune',
        'slug',
    ];
    use HasFactory;
}
