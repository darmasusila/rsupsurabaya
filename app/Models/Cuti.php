<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    //
    protected $table = 'cuti';
    // add fillable
    protected $fillable = [
        'pegawai_id',
        'jenis_cuti',
        'periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'file_name',
        'original_file_name',
        'mime_type',
        'status_atasan',
        'status_pejabat',
        'lama',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    // cast
    protected $casts = [
        'file_name' => 'array',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
