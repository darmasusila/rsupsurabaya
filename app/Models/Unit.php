<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    public $table = 'unit';
    // add fillable
    protected $fillable = [
        'nama',
        'keterangan',
        'direktorat_id',
        'struktural_id',
        'departemen_id',
        'created_at',
        'updated_at'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function struktural()
    {
        return $this->belongsTo(Struktural::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class);
    }

    public function fungsional()
    {
        return $this->belongsTo(Fungsional::class);
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
