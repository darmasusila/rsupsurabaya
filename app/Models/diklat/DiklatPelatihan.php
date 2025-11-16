<?php

namespace App\Models\Diklat;

use Illuminate\Database\Eloquent\Model;

class DiklatPelatihan extends Model
{
    //
    protected $table = 'diklat_pelatihan';

    // add fillable
    protected $fillable = [
        'pegawai_id',
        'diklat_jenis_id',
        'diklat_kategori_id',
        'diklat_metode_id',
        'judul',
        'penyelenggara',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'peran',
        'sumber_dana',
        'biaya',
        'status',
    ];

    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->belongsTo(\App\Models\Pegawai::class, 'pegawai_id');
    }

    public function diklatJenis()
    {
        return $this->belongsTo(DiklatJenis::class, 'diklat_jenis_id');
    }

    public function diklatKategori()
    {
        return $this->belongsTo(DiklatKategori::class, 'diklat_kategori_id');
    }

    public function diklatMetode()
    {
        return $this->belongsTo(DiklatMetode::class, 'diklat_metode_id');
    }
}
