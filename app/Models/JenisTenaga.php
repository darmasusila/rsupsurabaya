<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTenaga extends Model
{
    //
    public $table = 'jenis_tenaga';
    // add fillable
    protected $fillable = [
        'nama',
        'urutan'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
}
