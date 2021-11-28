@extends('components.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" type="text/css"/>
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/demo/default/custom/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script>
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title text-uppercase m-subheader__title--separator">
                    Tambah Produksi
                </h3>
            </div>
        </div>
    </div>

    <form method="POST" 
        action="{{ route('produksiInsert') }}" 
        class="form-send m-form m-form--fit m-form--label-align-right" 
        data-redirect="{{ route('produksiList') }}">

        {{ csrf_field() }}

        <div class="m-content">

            <div class="m-portlet akses-list">

                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="mportlet__head-icon">
                                <li class="flaticon-placeholder-2"></li>
                            </span>
                        <h3 class="m-portlet__head-text">
                            Data Produksi
                        </h3>
                        </div>
                    </div>
                </div>
            
                <div class="m-portlet__body">
                    <div class="form-goup m-form__group">
                        <label>
                            Kode Produksi
                        </label>
                        <input type="text" name="kode_produksi" class="form-control m-input">
                    </div>
                    <div class="form-goup m-form__group">
                        <label>
                            Mulai Produksi
                        </label>
                        <input type="date" name="tgl_mulai_produksi" class="form-control m-input">
                    </div>
                    <div class="form-goup m-form__group">
                        <label>
                            Selesai Produksi
                        </label>
                        <input type="date" name="tgl_selesai_produksi" class="form-control m-input">
                    </div>
                    <div class="form-goup m-form__group">
                        <label>
                            Pabrik
                        </label>
                        <select name="id_lokasi" class="form-control m-input">
                            @foreach ($lokasi as $row)
                                <option value="{{ $row->id }}">{{ $row->kode_lokasi.'-'.$row->lokasi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-form__group">
                        <label>
                            Catatan
                        </label>
                        <textarea name="catatan" class="form-control m-input"></textarea>
                    </div>
                </div>
            </div>

            <div class="m-portlet akses-list">

                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <li class="flaticon-placeholder-2"></li>
                                </span>
                            <h3 class="m-portlet__head-text">
                                Pilih Produk
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <button type="button" class="btn btn-success btn-produk-tambah">Tambah Produk</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Qty Produksi</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        
            <div class="m-portlet akses-list">

                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-placeholder-2"></i>
                                </span>
                            <h3 class="m-portlet__head-text">
                                Daftar Bahan
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body data-bahan-view">

                </div>
            </div>
            <div class="m-portlet akses-list">
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions text-center">
                        <button type="submit" class="btn btn-primary">
                            Mulai Produksi
                        </button>
                        <a href="{{ route('produksiList') }}" class="btn btn-secondary">
                            Kembali Ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="m--hide">
    <table class="table-produk-row">
        <tbody>
            <tr>
                <td class="produk">
                    <select name="id_produk" class="form-control">
                        @foreach ($produk as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_produk }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="qty">
                    <input type="number" class="form-control" name="qty_produksi" value="0">
                </td>
                <td>
                    <textarea name="keterangan" class="form-control"></textarea>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-produk-hapus">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection