<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostingLiked extends Model
{
    //
    public $table = 'posting_liked';
    // add fillable
    protected $fillable = ['posting_id', 'pegawai_id', 'tanggal_liked', 'is_open_link'];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function posting()
    {
        return $this->belongsTo(Posting::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
