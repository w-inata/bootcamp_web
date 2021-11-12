<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mProduksi extends Model
{
    protected $table = 'tb_produksi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'urutan',
        'id_lokasi',
        'kode_produksi',
        'tgl_mulai_produksi',
        'tgl_selesai_produksi',
        'catatan',
        'status',
        'status_finish_date',
        'publish',
        'publish_date',
        'finish',
    ];

    function lokasi()
    {
        return $this->belongsTo(mLokasi::class, 'id_lokasi');
    }
}
