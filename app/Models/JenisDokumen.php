<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    //
    public $table = 'jenis_dokumen';
    // add fillable
    protected $fillable = [
        'kode_jenis_dokumen',
        'nama_jenis_dokumen',
        'deskripsi',
        'durasi_reminder'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
