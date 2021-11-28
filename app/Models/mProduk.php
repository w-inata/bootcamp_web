<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mProduk extends Model
{

    protected $table = 'tb_produk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_kategori_produk',
        'id_lokasi',
        'kode_produk',
        'nama_produk',
        'harga_eceran',
        'harga_grosir',
        'harga_konsinyasi',
        'minimal_stok',
        'disc_persen',
        'disc_nominal',
    ];
}
