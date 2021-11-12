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
                    Edit Produksi
                </h3>
            </div>
        </div>
    </div>
    <div class="m-content">
        <div class="m-portlet akses-list">
            <form method="POST" 
                action="{{ route('produksiUpdate', ['id' => $edit->id]) }}" 
                class="form-send m-form m-form--fit m-form--label-align-right" 
                data-redirect="{{ route('produksiList') }}">

                {{ csrf_field() }}

                <div class="m-portlet__body">
                    <div class="form-goup m-form__group">
                        <label>
                            Kode Produksi
                        </label>
                        <input type="text" name="kode_produksi" value="{{ $edit->kode_produksi }}" class="form-control m-input">
                    </div>
                    <div class="form-goup m-form__group">
                        <label>
                            Mulai Produksi
                        </label>
                        <input type="date" name="tgl_mulai_produksi" value="{{ $edit->tgl_mulai_produksi }}" class="form-control m-input">
                    </div>
                    <div class="form-goup m-form__group">
                        <label>
                            Selesai Produksi
                        </label>
                        <input type="date" name="tgl_selesai_produksi" value="{{ $edit->tgl_selesai_produksi }}" class="form-control m-input">
                    </div>
                    <div class="form-goup m-form__group">
                        <label>
                            Pabrik
                        </label>
                        <select name="id_lokasi" class="form-control m-input">
                            @foreach ($lokasi as $row)
                                <option value="{{ $row->id }}" {{ $row->id == $edit->id_lokasi ? 'selected' : '' }}>
                                {{ $row->kode_lokasi.'-'.$row->lokasi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-form__group">
                        <label>
                            Catatan
                        </label>
                        <textarea name="catatan" class="form-control m-input">{{ $edit->catatan }}</textarea>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <button type="submit" class="btn btn-primary">
                            Perbarui Produksi
                        </button>
                        <a href="{{ route('produksiList') }}" class="btn btn-secondary">
                            Kembali Ke Daftar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection