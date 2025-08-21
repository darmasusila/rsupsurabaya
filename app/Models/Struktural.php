<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Struktural extends Model
{
    //
    public $table = 'struktural';
    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function direktorat()
    {
        return $this->hasMany(Direktorat::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
