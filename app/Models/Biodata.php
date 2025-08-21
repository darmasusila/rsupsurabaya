<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    //
    public $table = 'biodata';
    // add fillable
    protected $fillable = [
        'nama',
        'gelar_depan',
        'gelar_belakang',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'email',
        'agama',
        'status_perkawinan',
        'golongan_darah',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function pendidikan()
    {
        return $this->hasMany(Pendidikan::class);
    }

    public function GetNamaLengkapAttribute()
    {
        return trim("{$this->gelar_depan} {$this->nama} {$this->gelar_belakang}");
    }

    public function GetTanggalLahirFormattedAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->format('d-m-Y') : null;
    }

    public function GetUserCreatedAttribute(): ?bool
    {
        $user = \App\Models\User::where('email', $this->email)->first();

        if (!$user)
            return false;

        return true;
    }
}
