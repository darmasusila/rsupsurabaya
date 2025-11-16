<?php

namespace App\Models\Diklat;

use Illuminate\Database\Eloquent\Model;

class DiklatMetode extends Model
{
    //
    protected $table = 'diklat_metode';
    // add fillable
    protected $fillable = [
        'nama',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'nama' => 'string',
    ];

    public function diklatPelatihans()
    {
        return $this->hasMany(DiklatPelatihan::class, 'diklat_metode_id');
    }
}
