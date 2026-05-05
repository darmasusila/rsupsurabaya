<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaksinasi extends Model
{
    //
    protected $table = 'vaksinasi';
    public function biodata()
    {
        return $this->belongsTo(Biodata::class, 'biodata_id');
    }

    // add fillable
    protected $fillable = [
        'biodata_id',
        'jenis_vaksin',
        'tanggal_vaksin',
        'keterangan',
    ];

    // add guarded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
