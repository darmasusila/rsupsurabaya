<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    //
    public $table = 'departemen';
    // add fillable
    protected $fillable = ['nama', 'direktorat_id'];
    // add guarded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class);
    }
}
