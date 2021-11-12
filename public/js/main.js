$(document).ready(function(){
    datatable();
    form_send();
    hapus();
});

function datatable(){
    $('.datatable').each(function(){

        var _token = $('body').data('csrf-token');
        var url = $(this).data('url');
        var column = $(this).data('column');

        console.log(_token, url, column);

        $(this).DataTable({
            "searching":false,
            "processing":true,
            "serverSide":true,
            "ordering":true,
            "order": [[0, "desc"]],
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": "no-sort"
                },
            ],
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: _token,
                },
            },
            "columns": column,
            "drawCallback": function() {

            }
        });
    });
}

function form_send() {
    $('.form-send').submit(function (e) {
        e.preventDefault();

        var self = $(this);
        var redirect = $(this).data('redirect');

        console.log(redirect);

        $.ajax({
            url: self.attr('action'),
            type: self.attr('method'),
            data: self.serialize(),
            error: function(json){
                $('.form-control-feedback').remove();
                $('.form-group').removeClass('has-danger');

                $.each(json.responseJSON.errors, function (key, value) {
                    $('[name="' + key + '"]').parents('.form-group').addClass('has-danger');
                    $('[name="' + key + '"]').after('<span class="form-control-feedback">' + value + '</span>');
                });
            },
            success: function(json){
                window.location.href = redirect;
            }
        });
        return false;
    });
}

function hapus() {
    $('.datatable').on('click', '.btn-hapus', function (e) {
        e.preventDefault;
        var route = $(this).data('route');
        var _token = $('body').data('csrf-token');

        Swal.fire({
            title: 'Apakah yakin menghapus data ini ?',
            text: "Data ini akan terhapus secara permanen jika di proses",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, saya yakin'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: route,
                    type: 'delete',
                    data: {
                        _token: _token
                    },
                    success: function(){
                        window.location.reload();
                    }
                });
            }
        })
    });
}