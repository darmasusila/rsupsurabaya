<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    //
    public $table = 'pegawai';
    // add fillable
    protected $fillable = [
        'biodata_id',
        'status_kepegawaian_id',
        'unit_id',
        'struktural_id',
        'pendidikan_id',
        'fungsional_id',
        'jenis_tenaga_id',
        'nip',
        'tingkat_ahli',
        'kelas_jabatan',
        'golongan',
        'tmt_golongan',
        'no_sk',
        'no_str',
        'no_sip',
        'tanggal_akhir',
        'is_active',
        'tgl_promosi',
        'tgl_mutasi',
        'tgl_pensiun',
        'departemen_id',
        'direktorat_id',
        'created_at',
        'updated_at',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    // protected $hidden = ['created_at', 'updated_at'];

    public function biodata()
    {
        return $this->belongsTo(Biodata::class, 'biodata_id');
    }

    public function fungsional()
    {
        return $this->belongsTo(Fungsional::class, 'fungsional_id');
    }

    public function struktural()
    {
        return $this->belongsTo(Struktural::class, 'struktural_id');
    }

    public function jenisTenaga()
    {
        return $this->belongsTo(JenisTenaga::class, 'jenis_tenaga_id');
    }

    public function statusKepegawaian()
    {
        return $this->belongsTo(StatusKepegawaian::class, 'status_kepegawaian_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class, 'direktorat_id');
    }

    public function pendidikan()
    {
        return $this->hasMany(Pendidikan::class, 'biodata_id', 'biodata_id');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }

    public function isActive()
    {
        return $this->is_active ?? true; // Default to true if not set
    }

    public function setIsActive($value)
    {
        $this->is_active = $value;
        $this->save();
    }
    // Add other relationships and methods as necessary
    public function getFullNameAttribute()
    {
        return $this->biodata ? $this->biodata->nama : 'Unknown';
    }

    public function getNipAttribute()
    {
        return $this->nip ?? 'N/A';
    }

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function cutis()
    {
        return $this->hasMany(Cuti::class, 'pegawai_id');
    }

    public function plafonCutis()
    {
        return $this->hasMany(PlafonCuti::class, 'pegawai_id');
    }

    public function getAtasanAttribute()
    {
        if ($this->unit_id) {
            $struktural_id = Unit::find($this->unit_id)->struktural_id;
            $struktural = Struktural::find($struktural_id);
            $atasanPegawai = Pegawai::where('struktural_id', $struktural_id)->first();
            return $atasanPegawai ? '<p>Tenaga Ahli ' . $struktural->nama . '</p><b>' . $atasanPegawai->biodata->nama . '</b>' : 'N/A';
        }
        return 'N/A';
    }
}
