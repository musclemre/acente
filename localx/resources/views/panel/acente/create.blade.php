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
        <div class="actions">
        </div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal" role="form" method="post">
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Acente Adı</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Acente Adı">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Açıklama</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Acente ile ilgili açıklayıcı bilgiler">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Sorumlu Adı ve Telefonu</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" placeholder="Acente Sorumlusu">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Sorumlu Telefon Numarası">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="slug">Slug</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Slug" id="slug" name="slug">
                        <span class="help-block"> Slug değeri subdomain olarak kullanılacaktır! Sistem üzerinde benzersiz olması gerekmektedir. </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Başlangıç Durumu</label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline">
                            <label class="mt-radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios25" value="1" checked>
                                Aktif
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios26" value="0">
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

@endsection
