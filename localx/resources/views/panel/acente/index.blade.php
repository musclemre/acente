@extends('layouts.app')

@section('content')

    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Acente Listesi</h1>
        </div>
        <!-- END PAGE TITLE -->
    </div>
    <!-- END PAGE HEAD-->
    <!-- BEGIN PAGE BREADCRUMB -->
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{route('panel.dashboard')}}">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Acente Listesi</span>
        </li>
    </ul>

    <div class="portlet-title">
        <div class="actions">
            <a href="{{route('panel.acenteler.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Acente Oluştur</a>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="datatable">
            <thead>
            <tr>
                <th class="all">ID</th>
                <th class="all">Kod</th>
                <th class="all">Acente Adı</th>
                <th class="all">Sorumlu</th>
                <th class="all">Eklenme Tarihi</th>
                <th class="min-phone-l">Durum</th>
                <th class="min-phone-l">İşlem</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

@endsection

@section('js')

    <script>
        $(document).ready(function () {
            // DataTable başlatmadan önce elementin var olduğunu kontrol edin
            if ($('#datatable').length === 0) {
                console.error('DataTable elementi bulunamadı!');
                return;
            }

            var table = $('#datatable').DataTable({
                // Sıralama özellikleri
                "order": [[0, "desc"]],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{route('panel.acenteler.index'). '?datatable=1'}}",
                    "type": "GET",
                    "dataType": "json",
                    "data": function (d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                    },
                    "error": function (xhr, error, code) {
                        console.error('DataTable AJAX hatası:', error);
                    }
                },
                "columns": [
                    {"data": "id"},
                    {"data": "kod"},
                    {"data": "acente_adi"},
                    {"data": "sorumlu"},
                    {"data": "created_at"},
                    {"data": "durum", className: "text-center"},
                    {
                        "data": null,
                        "orderable": false,
                        "searchable": false,
                        className: "center",
                        "render": function (data, type, row) {
                            return `
                        <div class="btn-group pull-right">
                            <button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">İşlemler
                                <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;" onclick="viewDetails(${row.id})">
                                        <i class="fa fa-eye"></i> Görüntüle </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="editRecord(${row.id})">
                                        <i class="fa fa-edit"></i> Düzenle </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="deleteRecord(${row.id})">
                                        <i class="fa fa-trash"></i> Sil </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:;" onclick="printRecord(${row.id})">
                                        <i class="fa fa-print"></i> Yazdır </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="exportPDF(${row.id})">
                                        <i class="fa fa-file-pdf-o"></i> PDF olarak kaydet </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="exportExcel(${row.id})">
                                        <i class="fa fa-file-excel-o"></i> Excel'e aktar </a>
                                </li>
                            </ul>
                        </div>
                    `;
                        }
                    }
                ],
                "responsive": true,
                "language": {
                    "processing": "İşleniyor...",
                    "search": "Ara:",
                    "lengthMenu": "Sayfada _MENU_ kayıt göster",
                    "info": "_TOTAL_ kayıttan _START_ - _END_ arası kayıtlar gösteriliyor",
                    "infoEmpty": "Kayıt yok",
                    "infoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
                    "loadingRecords": "Yükleniyor...",
                    "zeroRecords": "Eşleşen kayıt bulunamadı",
                    "emptyTable": "Tabloda herhangi bir veri mevcut değil",
                    "paginate": {
                        "first": "İlk",
                        "previous": "Önceki",
                        "next": "Sonraki",
                        "last": "Son"
                    }
                },
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]],
                "buttons": [
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel\'e Aktar',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf-o"></i> PDF',
                        titleAttr: 'PDF\'e Aktar',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Yazdır',
                        titleAttr: 'Yazdır',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });

            // İşlemler için JavaScript fonksiyonları

            window.viewDetails = function (id) {
                // Detay görüntüleme işlemi
                $.ajax({
                    url: '/panel/acente/view/' + id,
                    type: 'GET',
                    success: function (response) {
                        // Detay modalını aç ve içeriği doldur
                        $('#detailModal .modal-body').html(response);
                        $('#detailModal').modal('show');
                    }
                });
            };

            window.editRecord = function (id) {
                // Düzenleme sayfasına yönlendir
                window.location.href = '/panel/acente/edit/' + id;
            };

            window.deleteRecord = function (id) {
                // Silme onayı iste
                if (confirm('Bu kaydı silmek istediğinizden emin misiniz?')) {
                    $.ajax({
                        url: '/panel/acente/delete/' + id,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'DELETE'
                        },
                        success: function (response) {
                            // Başarılı silme işlemi sonrası
                            if (response.success) {
                                // Tabloyu yenile
                                table.ajax.reload();
                                // Bildirim göster
                                toastr.success('Kayıt başarıyla silindi.');
                            } else {
                                toastr.error('Silme işlemi başarısız.');
                            }
                        },
                        error: function () {
                            toastr.error('Bir hata oluştu.');
                        }
                    });
                }
            };

            window.printRecord = function (id) {
                // Tek kayıt yazdırma
                window.open('/panel/acente/print/' + id, '_blank');
            };

            window.exportPDF = function (id) {
                // Tek kayıt PDF'e aktarma
                window.open('/panel/acente/export/pdf/' + id, '_blank');
            };

            window.exportExcel = function (id) {
                // Tek kayıt Excel'e aktarma
                window.open('/panel/acente/export/excel/' + id, '_blank');
            };

            // Filtreleme için örnek kod - gerekliyse kullanabilirsiniz
            $('#filter-status').change(function () {
                table.column(2).search($(this).val()).draw();
            });
        });
    </script>

@endsection
