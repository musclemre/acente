@extends('layouts.app')

@section('content')

    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Acente Oluştur</h1>
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
            <a href="{{route('panel.acenteler.index')}}">Acente Listesi</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Acente Oluştur</span>
        </li>
    </ul>

    <div class="portlet-title">
        <span class="alert alert-info" style="padding: 2px;">Burada yazan bilgiler acente sayfasında görünmez! Adminin acenteleri kontrol edebilmesi için kullanılır.</span>
        <div class="actions">
        </div>
    </div>
    <div class="portlet-body">
        @include('layouts.partials.validation')
        @if(session()->has('error'))
            {{session('error')}}
        @endif
        <form class="form-horizontal" role="form" method="post"
              action="{{route('panel.acenteler.update', $acente->id)}}">
            @csrf
            @method('PUT')
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Acente Kodu</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" readonly value="{{$acente->kod}}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Acente Adı</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Acente Adı" name="acente_adi" required
                               value="{{$acente->acente_adi}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Açıklama</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Acente ile ilgili açıklayıcı bilgiler"
                               name="acente_aciklama" required value="{{$acente->acente_aciklama}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Sorumlu Adı ve Telefonu</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" placeholder="Acente Sorumlusu" name="sorumlu_adi"
                               value="{{$acente->sorumlu_adi}}">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Sorumlu Telefon Numarası" maxlength="20"
                               name="sorumlu_telefon" value="{{$acente->sorumlu_telefon}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="slug">Slug</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Slug" id="slug" name="slug" required
                               value="{{$acente->slug}}">
                        <span class="help-block"> Slug değeri subdomain olarak kullanılacaktır! Sistem üzerinde benzersiz olması gerekmektedir. </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Başlangıç Durumu</label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline">
                            <label class="mt-radio">
                                <input type="radio" name="durum" id="optionsRadios25"
                                       value="1" {{$acente->durum == 1 ? 'checked' : ''}}>
                                Aktif
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="durum" id="optionsRadios26"
                                       value="0" {{$acente->durum == 0 ? 'checked' : ''}}>
                                Pasif
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green">Kaydet</button>
                        <a type="button" class="btn default" href="{{route('panel.acenteler.index')}}">İptal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            let timeout;

            $('#slug').on('input', function () {
                const slugValue = $(this).val();
                const inputElement = $(this);

                // Önceki timeout'u temizle
                clearTimeout(timeout);

                // Input boşsa border'ı normale döndür
                if (!slugValue) {
                    inputElement.removeClass('border-danger border-success').css('border-color', '');
                    return;
                }

                // 500ms bekle (kullanıcı yazmayı bitirsin)
                timeout = setTimeout(function () {
                    // AJAX isteği gönder
                    $.ajax({
                        url: '{{route('panel.acenteler.checkSlug')}}', // Route'unuzu buraya yazın
                        method: 'POST',
                        data: {
                            slug: slugValue,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        beforeSend: function () {
                            // Loading durumunu göster (opsiyonel)
                            inputElement.removeClass('border-danger border-success').addClass('border-warning');
                        },
                        success: function (response) {
                            // Response 1, true veya "1" ise slug mevcut
                            if (response === 1 || response === true || response === "1") {
                                // Slug mevcut - kırmızı border
                                inputElement.removeClass('border-warning border-success').addClass('border-danger');
                                // Hata mesajı göster (opsiyonel)
                                showSlugMessage('Bu slug zaten kullanılıyor!', 'error');
                            } else {
                                // Slug uygun - yeşil border
                                inputElement.removeClass('border-warning border-danger').addClass('border-success');
                                // Başarı mesajı göster (opsiyonel)
                                showSlugMessage('Slug kullanılabilir!', 'success');
                            }
                        },
                        error: function () {
                            // Hata durumunda normal border
                            inputElement.removeClass('border-warning border-danger border-success').css('border-color', '');
                            showSlugMessage('Kontrol edilemedi, lütfen tekrar deneyin.', 'error');
                        }
                    });
                }, 500);
            });

            // Mesaj gösterme fonksiyonu (opsiyonel)
            function showSlugMessage(message, type) {
                const helpBlock = $('#slug').siblings('.help-block');
                const messageElement = $('#slug-message');

                // Önceki mesajı kaldır
                messageElement.remove();

                // Yeni mesaj ekle
                const alertClass = type === 'success' ? 'text-success' : 'text-danger';
                helpBlock.after(`<small id="slug-message" class="${alertClass}">${message}</small>`);

                // 3 saniye sonra mesajı kaldır
                setTimeout(function () {
                    $('#slug-message').fadeOut();
                }, 3000);
            }
        });
    </script>
@endsection
