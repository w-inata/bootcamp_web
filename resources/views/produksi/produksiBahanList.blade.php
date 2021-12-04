<table class="table table-border table-striped">
    <thead>
        <tr>
            <th>Kode Bahan</th>
            <th>Nama Bahan</th>
            <th>Qty Diperlukan</th>
            <th>Qty Tersedia</th>
            <th>Status</th>
            <th>Gudang</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($komposisi_produk as $key => $row)
            @php
                $qty_diperlukan = $row->komposisi_qty * $qty_produksi;
                $total_tersedia = \App\Models\mStokBahan
                    ::where([
                        'id_bahan'=>$row->id_bahan,
                    ])
                    ->sum('qty');
                $gudang = \App\Model\mStokBahan
                    ::leftJoin('tb_lokasi', 'tb_lokasi.id', '=', 'tb_stok_bahan.id_lokasi')
                    ->where('id_bahan', $row->id_bahan)
                    ->orderBy('lokasi', 'ASC')
                    ->get();
            @endphp

            <tr>
                <th>{{ $row->kode_bahan }}</th>
                <th>{{ $row->nama_bahan }}</th>
                <th>{{ $qty_diperlukan }}</th>
                <th>{{ $total_tersedia }}</th>
                <th>
                    @if ($qty_diperlukan > $total_tersedia)
                        <span class="m-badge m-badge--warning m-badge--wide">Bahan Tidak Cukup</span>
                    @else
                        <span class="m-badge m-badge--success m-badge--wide">Bahan Cukup</span>
                    @endif
                </th>
                <th>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Gudang</th>
                                <th>Stok Tersedia</th>
                                <th>Jumlah Stok Digunakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gudang as $row_gudang)
                                @php
                                    // qty setiap gudang
                                    $qty_bahan =0;
                                    $qty_stok = $row_gudang->qty;
                                    $id_stok_bahan= $row_gudang->id;

                                    if ($qty_diperlukan > 0) {
                                        if ($qty_diperlukan >= $qty_stok) {
                                            $qty_bahan = $qty_stok;
                                            $qty_diperlukan = $qty_diperlukan -$qty_stok;
                                        }else {
                                            $qty_bahan = $qty_diperlukan;
                                            $qty_diperlukan = 0;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $row_gudang->lokasi }}</td>
                                    <td>{{ $row_gudang->qty }}</td>
                                    <td>
                                        <input type="text"
                                                name="qty_digunakan[{{ $key }}][{{ $id_stok_bahan }}]"
                                                value="{{ $qty_bahan }}"
                                                class="form-control touchspin-number-decimal-js"
                                                max="{{ $qty_diperlukan }}"
                                                min="0">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </th>
            </tr>
        @endforeach
    </tbody>
</table>