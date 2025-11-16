<?php

namespace App\Models\Diklat;

use Illuminate\Database\Eloquent\Model;

class DiklatFellowshipJenis extends Model
{
    //
    protected $table = 'diklat_fellowship_jenis';
    // add fillable
    protected $fillable = [
        'nama',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function diklatFellowships()
    {
        return $this->hasMany(DiklatFellowship::class, 'diklat_fellowship_jenis_id');
    }
}
