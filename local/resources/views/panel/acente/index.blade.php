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
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="datatable">
            <thead>
            <tr>
                <th class="all">Acente Adı</th>
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
            // DataTable'ı başlat
            var table = $('#datatable').DataTable({
                "processing": true,           // İşlem göstergesini aç
                "serverSide": true,           // Sunucu taraflı işleme
                "ajax": {
                    "url": "{{route('panel.acenteler.index'). '?datatable'}}",  // Backend veri kaynağı URL'si
                    "type": "POST",           // HTTP metodu
                    "dataType": "json",
                    "data": function (d) {
                        // İlave parametreler eklenebilir
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        // Diğer filtreler buraya eklenebilir
                    }
                },
                "columns": [
                    {"data": "first_name"},
                    {"data": "last_name"},
                    {
                        "data": null,
                        "orderable": false,      // Bu sütun sıralanamaz
                        "searchable": false,     // Bu sütun aranamaz
                        "render": function (data, type, row) {
                            // İşlem butonları için HTML render et
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
                // Responsive ayarları
                "responsive": true,

                // Türkçe dil dosyası
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json",
                    // veya yerleşik olarak tanımlamak için:
                    "processing": "İşleniyor...",
                    "search": "Ara:",
                    "lengthMenu": "Sayfada _MENU_ kayıt göster",
                    "info": "_TOTAL_ kayıttan _START_ - _END_ arası kayıtlar gösteriliyor",
                    "infoEmpty": "Kayıt yok",
                    "infoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
                    "infoPostFix": "",
                    "loadingRecords": "Yükleniyor...",
                    "zeroRecords": "Eşleşen kayıt bulunamadı",
                    "emptyTable": "Tabloda herhangi bir veri mevcut değil",
                    "paginate": {
                        "first": "İlk",
                        "previous": "Önceki",
                        "next": "Sonraki",
                        "last": "Son"
                    },
                    "aria": {
                        "sortAscending": ": artan sütun sıralamasını aktifleştir",
                        "sortDescending": ": azalan sütun sıralamasını aktifleştir"
                    }
                },

                // Sıralama özellikleri
                "order": [[0, "asc"]], // Varsayılan olarak ilk sütuna göre artan sıralama

                // Varsayılan sayfa uzunluğu
                "pageLength": 10,

                // Sayfa uzunluğu seçenekleri
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]],

                // DOM yapısı (elemanların pozisyonu)
                "dom": '<"top"Bf>rt<"bottom"lip><"clear">',

                // Butonlar (Excel, PDF, Yazdır)
                "buttons": [
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel\'e Aktar',
                        exportOptions: {
                            columns: ':not(:last-child)' // Son sütunu hariç tut
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf-o"></i> PDF',
                        titleAttr: 'PDF\'e Aktar',
                        exportOptions: {
                            columns: ':not(:last-child)' // Son sütunu hariç tut
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Yazdır',
                        titleAttr: 'Yazdır',
                        exportOptions: {
                            columns: ':not(:last-child)' // Son sütunu hariç tut
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
