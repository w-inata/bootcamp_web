<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mStokBahan extends Model
{

    protected $table = 'tb_stok_bahan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_bahan',
        'id_lokasi',
        'no_seri_bahan',
        'qty',
        'keterangan',
    ];
}
