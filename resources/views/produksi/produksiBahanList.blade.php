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
        @foreach ($komosisi_produk as $row)
            @php
                $qty_diperlukan = $row->komposisi_qty * $qty_produksi;
                $total_tersedia = \App\Models\mStokBahan
                ::where([
                    'id_bahan'=>$row->id_bahan,
                ])
                ->sum('qty');
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
                <th>ini Bahan</th>
            </tr>
        @endforeach
    </tbody>
</table>