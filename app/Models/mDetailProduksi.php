<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mDetailProduksi extends Model
{
    protected $table = 'tb_detail_produksi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_produksi',
        'id_produk',
        'month',
        'year',
        'qty',
        'keterangan',
        'qty_progress'
    ];
}
