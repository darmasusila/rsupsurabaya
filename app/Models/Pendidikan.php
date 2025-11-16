<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    //
    public $table = 'pendidikan';
    // add fillable
    protected $fillable = [
        'biodata_id',
        'jenjang',
        'program_studi',
        'institusi',
        'tanggal_lulus',
        'keterangan',
        'institusi_spesialis',
        'institusi_subspesialis',
        'no_ijasah',
        'no_ijasah_subspesialis',
        'no_ijasah_spesialis',
        'created_at',
        'updated_at'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function biodata()
    {
        return $this->belongsTo(Biodata::class);
    }

    public function pegawai()
    {
        return $this->hasManyThrough(Pegawai::class, Biodata::class, 'id', 'biodata_id', 'biodata_id', 'id');
    }
}
