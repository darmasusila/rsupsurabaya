<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenNotifLog extends Model
{
    //
    public $table = 'dokumen_notif_log';
    // add fillable
    protected $fillable = [
        'dokumen_kepegawaian_id',
        'notified_at',
        'notification_type',
        'message',
        'recipient',
        'status'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function dokumenKepegawaian()
    {
        return $this->belongsTo(DokumenKepegawaian::class, 'dokumen_kepegawaian_id');
    }
}
