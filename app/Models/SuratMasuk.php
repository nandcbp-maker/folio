<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'no_berkas',
        'perihal',
        'asal_instansi',
        'tanggal_surat',
        'tanggal_terima',
        'kategori',
        'status',
        'file_path',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_terima' => 'date',
    ];

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }
}
