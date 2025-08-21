<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fungsional extends Model
{
    //
    public $table = 'fungsional';
    // add fillable
    protected $fillable = [
        'nama',
        'is_str'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function getIsStrAttribute($value)
    {
        return $value ? 'Ya' : 'Tidak';
    }
}
