<?php

namespace App\Models\Diklat;

use Illuminate\Database\Eloquent\Model;

class DiklatFellowship extends Model
{
    //
    protected $table = 'diklat_fellowship';
    // add fillable
    protected $fillable = [
        'pegawai_id',
        'diklat_fellowship_jenis_id',
        'judul',
        'penyelenggara',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'sumber_dana',
        'biaya',
        'status',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function diklatFellowshipJenis()
    {
        return $this->belongsTo(DiklatFellowshipJenis::class, 'diklat_fellowship_jenis_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(\App\Models\Pegawai::class, 'pegawai_id');
    }
}
