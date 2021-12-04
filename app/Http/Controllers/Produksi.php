<?php

namespace App\Http\Controllers;

use App\Models\mKomposisiProduk;
use App\Models\mProduksi;
use App\Models\mLokasi;
use App\Models\mProduk;
use App\Models\mBahan;
use App\Models\mBahanProduksi;
use App\Models\mDetailProduksi;
use App\Models\mStokBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Produksi extends Controller
{
    function index()
    {
        $datatable_column = [
            ["data" => "no"],
            ["data" => "kode_produksi"],
            ["data" => "lokasi"],
            ["data" => "tanggal_mulai"],
            ["data" => "tanggal_selesai"],
            ["data" => "status"],
            ["data" => "publish"],
        ];
        $data = [
            'datatable_column' => $datatable_column
        ];
        return view('produksi.produksiList', $data);
    }

    function datatable(Request $request)
    {
        $total_data = mProduksi::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id';
        $order_type = $request->input('order.0.dir');

        $data_list = mProduksi
            ::with([
                'lokasi'
            ])
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->get();

        $total_data++;

        $data = array();
        foreach ($data_list as $key => $row) {
            $key++;
            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $no;
            $nestedData['kode_produksi'] = $row->kode_produksi;
            $nestedData['lokasi'] = $row->lokasi->lokasi;
            $nestedData['tanggal_mulai'] = $row->tgl_mulai_produksi;
            $nestedData['tanggal_selesai'] = $row->tgl_selesai_produksi;
            $nestedData['status'] = $row->status;
            $nestedData['publish'] = $row->publish;
            $nestedData['menu'] = '
            <div class="btn-group m-btn-group" role="group" aria-label="...">
                <a href="' . route('produksiEdit', ['id' => $row->id]) . '" class="btn-success">
                    Edit
                </a>
                <button type="button" class="btn btn-danger btn-hapus" data-route="' . route('produksiDelete', ['id' => $row->id]) . '">
                    Hapus
                </button>
            </div>
            
            ';

            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($total_data - 1),
            "recordsFoltered" => intval($total_data - 1),
            "data" => $data,
            "all_request" => $request->all()
        );
        return $json_data;
    }

    function create()
    {
        $lokasi = mLokasi::all();
        $produk = mProduk::all();

        $data = [
            'lokasi' => $lokasi,
            'produk' => $produk
        ];

        return view('produksi.produksiCreate', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'kode_produksi' => 'required',
            'tgl_mulai_produksi' => 'required',
            'tgl_selesai_produksi' => 'required',
            'id_lokasi' => 'required',
            'catatan' => 'required',
            'id_produk' => 'required',
            'id_produk.*' => 'required',
            'qty_digunakan' => 'required',
            'qty_digunakan.*' => 'required',
        ]);

        $kode_produksi = $request->input('kode_produksi');
        $tgl_mulai_produksi = date('Y-m-d', strtotime($request->input('tgl_mulai_produksi')));
        $tgl_selesai_produksi = date('Y-m-d', strtotime($request->input('tgl_selesai_produksi')));
        $id_lokasi = $request->input('id_lokasi');
        $catatan = $request->input('catatan');
        $id_produk_arr = $request->input('id_produk');
        $qty_produksi_arr = $request->input('qty_produksi');
        $keterangan_arr = $request->input('keterangan');
        $qty_digunakan_arr = $request->input('qty_digunakan');
        $month = $request->input('m', strtotime($tgl_mulai_produksi));
        $year = $request->input('Y', strtotime($tgl_mulai_produksi));
        $date_modified = date('Y-m-d H:i:s');

        DB::beginTransaction();
        try {
            $data_insert = [
                'kode_produksi' => $kode_produksi,
                'tgl_mulai_produksi' => $tgl_mulai_produksi,
                'tgl_selesai_produksi' => $tgl_selesai_produksi,
                'id_lokasi' => $id_lokasi,
                'catatan' => $catatan
            ];

            $id_produksi = mProduksi::create($data_insert)->id;

            $data_detail_produksi = [];
            foreach ($id_produk_arr as $key => $id_produk) {
                $qty_produksi = $qty_produksi_arr[$key];
                $keteangan = $keterangan_arr[$key];
                $data_detail_produksi[] = [
                    'id_produksi' => $id_produksi,
                    'id_produk' => $id_produk,
                    'month' => $month,
                    'year' => $year,
                    'qty' => $qty_produksi,
                    'keterangan' => $keteangan,
                    'create_at' => $date_modified,
                    'update_at' => $date_modified
                ];
            }


            mDetailProduksi::insert($data_detail_produksi);

            $data_bahan_produksi = [];
            foreach ($qty_digunakan_arr as $key => $id_stok_bahan_arr) {
                foreach ($id_stok_bahan_arr as $id_stok_bahan => $qty_digunakan) {
                    $id_bahan = mStokBahan::where('id', $id_stok_bahan)->value('id_bahan');
                    $id_bahan = $id_bahan ? $id_bahan : 0;
                    $id_satuan = mBahan::where('id', $id_bahan)->value('id_satuan');
                    $id_satuan = $id_satuan ? $id_satuan : 0;
                    $id_lokasi = mStokBahan::where('id', $id_stok_bahan)->value('id_lokasi');
                    if ($id_lokasi) {
                        $lokasi = mLokasi::where('id', $id_lokasi)->first();
                        $gudang_qty = $lokasi['lokasi'];
                    } else {
                        $gudang_qty = '';
                    }

                    $qty = mStokBahan::where('id', $id_stok_bahan)->value('qty');
                    $qty = $qty ? $qty : 0;

                    $data_bahan_produksi[] = [
                        'id_produksi' => $id_produksi,
                        'id_bahan' => $id_bahan,
                        'id_satuan' => $id_satuan,
                        'qty_diperlukan' => $qty_digunakan,
                        'gudang_qty' => $gudang_qty,
                        'qty' => $qty,
                        'created_at' => $date_modified,
                        'updated_at' => $date_modified
                    ];
                }
            }

            mBahanProduksi::insert($data_bahan_produksi);
            DB::commit();
        } catch (\Exception $exception) {
            throw $exception;
            DB::rollBack();
        }
    }

    function edit($id)
    {
        $lokasi = mLokasi::all();
        $edit = mProduksi::where('id', $id)->first();

        $data = [
            'lokasi' => $lokasi,
            'edit' => $edit
        ];

        return view('produksi.produksiEdit', $data);
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'kode_produksi' => 'required',
            'tgl_mulai_produksi' => 'required',
            'tgl_selesai_produksi' => 'required',
            'id_lokasi' => 'required',
            'catatan' => 'required',
        ]);

        $kode_produksi = $request->input('kode_produksi');
        $tgl_mulai_produksi = date('Y-m-d', strtotime($request->input('tgl_mulai_produksi')));
        $tgl_selesai_produksi = date('Y-m-d', strtotime($request->input('tgl_selesai_produksi')));
        $id_lokasi = $request->input('id_lokasi');
        $catatan = $request->input('catatan');

        $data_update = [
            'kode_produksi' => $kode_produksi,
            'tgl_mulai_produksi' => $tgl_mulai_produksi,
            'tgl_selesai_produksi' => $tgl_selesai_produksi,
            'id_lokasi' => $id_lokasi,
            'catatan' => $catatan
        ];

        mProduksi::where('id', $id)->update($data_update);
    }

    function delete($id)
    {
        mProduksi::where('id', $id)->delete();
    }

    function bahan_list(Request $request)
    {
        $id_produk = $request->input('id_produk');
        $qty_produksi = $request->input('qty_produksi');

        $komposisi_produk = mKomposisiProduk
            ::select([
                'tb_bahan.*',
                'tb_komposisi_produk.*',
                'tb_komposisi_produk.qty AS komposisi_qty'
            ])
            ->leftJoin('tb_bahan', 'tb_bahan.id', 'tb_komposisi_produk.id_bahan')
            ->where('tb_komposisi_produk.id_produk', $id_produk)
            ->orderBay('nama_bahan', 'ASC')
            ->get();

        $data = [
            'qty_produksi' => $qty_produksi,
            'komposisi_produk' => $komposisi_produk
        ];

        return view('produksi.produksiBahanList', $data);
    }
}
