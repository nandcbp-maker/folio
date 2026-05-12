<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'no_surat',
        'perihal',
        'tujuan',
        'tanggal_surat',
        'isi_surat',
        'status',
        'template_type',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];
}
