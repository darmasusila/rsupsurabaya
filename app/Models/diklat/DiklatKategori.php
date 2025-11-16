<?php

namespace App\Models\Diklat;

use Illuminate\Database\Eloquent\Model;

class DiklatKategori extends Model
{
    //
    protected $table = 'diklat_kategori';
    // add fillable
    protected $fillable = [
        'nama',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function diklatPelatihans()
    {
        return $this->hasMany(DiklatPelatihan::class, 'diklat_kategori_id');
    }
}
