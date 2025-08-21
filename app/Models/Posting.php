<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    //
    public $table = 'posting';
    // add fillable
    protected $fillable = ['judul', 'jenis', 'url', 'is_active'];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function likes()
    {
        return $this->hasMany(PostingLiked::class);
    }
}
