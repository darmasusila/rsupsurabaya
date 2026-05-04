<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DokumenKepegawaian extends Model
{
    //
    public $table = 'dokumen_kepegawaian';
    // add fillable
    protected $fillable = [
        'pegawai_id',
        'jenis_dokumen_id',
        'nomor_dokumen',
        'tanggal_terbit',
        'tanggal_berakhir',
        'file_path',
        'status',
        'catatan'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'jenis_dokumen_id');
    }

    // buat atribut untuk menghitung sisa waktu sebelum dokumen kadaluarsa
    public function getSisaWaktuAttribute()
    {
        // dapatkan lama waktu sebelum dokumen kadaluarsa dari jenis dokumen
        $durasiReminder = $this->jenisDokumen->durasi_reminder;
        $tanggalBerakhir = Carbon::parse($this->tanggal_berakhir);
        $tanggalSekarang = now();
        if ($tanggalBerakhir->isPast()) {
            return 'Kadaluarsa';
        } elseif ($tanggalBerakhir->diffInDays($tanggalSekarang) <= $durasiReminder) {
            return 'Peringatan: ' . abs(round($tanggalBerakhir->diffInDays($tanggalSekarang))) . ' hari tersisa';
        } else {
            return '';
        }
    }
}
