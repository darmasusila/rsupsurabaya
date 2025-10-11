<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direktorat extends Model
{
    //
    public $table = 'direktorat';
    // add fillable
    protected $fillable = [
        'nama',
        'struktural_id',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function struktural()
    {
        return $this->belongsTo(Struktural::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
}
