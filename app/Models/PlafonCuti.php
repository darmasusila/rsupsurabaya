<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlafonCuti extends Model
{
    //
    protected $table = 'plafon_cuti';
    // add fillable
    protected $fillable = [
        'pegawai_id',
        'jenis_cuti',
        'periode',
        'jumlah_hari',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    // cast
    protected $casts = [
        'jumlah_hari' => 'integer',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
