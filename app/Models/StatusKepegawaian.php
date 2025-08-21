<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusKepegawaian extends Model
{
    //
    public $table = 'status_kepegawaian';
    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
}
