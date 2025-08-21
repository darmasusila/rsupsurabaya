<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    //
    protected $table = 'dokumen';
    // add fillable
    protected $fillable = [
        'kategori',
        'nama_dokumen',
        'deskripsi',
        'slug',
        'url',
        'nama_pengupload',
        'path',
        'file_name',
        'original_file_name',
        'mime_type',
        'counter',
        'is_active',
    ];
    // add guarded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    // cast
    protected $casts = [
        'file_name' => 'array',
    ];
}
