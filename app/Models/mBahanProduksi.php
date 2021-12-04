<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mBahanProduksi extends Model
{
    protected $table = 'tb_bahan_produksi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_produksi',
        'id_bahan',
        'id_satuan',
        'qty_diperlukan',
        'gudang_qty'
    ];
}
