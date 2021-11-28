<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mBahan extends Model
{

    protected $table = 'tb_bahan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kategori_bahan',
        'id_satuan',
        'id_supplier',
        'kode_bahan',
        'nama_bahan',
        'minimal_stok',
        'qty',
        'last_stok',
        'harga',
        'id_lokasi',
        'keterangan',
    ];
}
