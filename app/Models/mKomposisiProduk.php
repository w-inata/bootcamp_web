<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mKomposisiProduk extends Model
{

    protected $table = 'tb_komposisi_produk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_produk',
        'id_bahan',
        'id_satuan',
        'qty',
    ];

    function produk()
    {
        return $this->belongsTo(mProduk::class, 'id_produk', 'id');
    }
    function bahan()
    {
        return $this->belongsTo(mBahan::class, 'id_produk', 'id');
    }
}
