<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    //
    protected $table = 'magang';
    // add fillable
    protected $fillable = [
        'biodata_id',
        'jenis_tenaga_id',
        'status_kepegawaian_id',
        'unit_id',
        'mentor_id',
        'ipk',
        'tanggal_mulai',
        'tanggal_selesai',
        'instansi',
        'pendidikan',
        'catatan',
        'is_active',
        'posisi',
        'penempatan',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    // add relationships
    public function biodata()
    {
        return $this->belongsTo(Biodata::class);
    }

    public function jenisTenaga()
    {
        return $this->belongsTo(JenisTenaga::class);
    }

    public function statusKepegawaian()
    {
        return $this->belongsTo(StatusKepegawaian::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Pegawai::class, 'mentor_id');
    }
}
