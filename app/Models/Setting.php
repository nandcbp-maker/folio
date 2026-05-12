<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'nama_institusi',
        'alamat',
        'kota',
        'kode_pos',
        'telepon',
        'email',
        'logo',
        'tanda_tangan',
        'format_nomor_surat',
        'digit_nomor',
        'reset_nomor',
    ];
}
