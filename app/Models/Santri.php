<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $fillable = [
    'nis',
    'nama',
    'kelas',
    'kamar',
    'jenis_kelamin'
];
}
