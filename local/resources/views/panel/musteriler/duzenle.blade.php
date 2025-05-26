@extends('layouts.app')

@section('content')
	<!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Müşteri Düzenle</h1>
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
            <span class="active">Müşteri Düzenle</span>
        </li>
    </ul>

    <div class="portlet-title">
        <div class="actions">
        </div>
    </div>
	
	<div class="portlet-body form">
		<div class="row">
            <div class="col-md-12 col-sm-12">
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				@if(Session::has('hata'))
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
						<strong>{{Session::get('hata')}}</strong>
					</div>
				@endif
				@if(Session::has('ok'))
					<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
						<strong>{{Session::get('ok')}}</strong>
					</div>
				@endif
				<form action="{{url('panel/musteriler/duzenle',$musteri->id)}}" id="form_islem" class="form-horizontal form-bordered" method="post">
					{!! csrf_field() !!}
					<div class="form-body">
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Tc
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="tc" type="text" value="{{$musteri->tc}}" maxlength="11" class="form-control" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Ad Soyad
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="name" type="text" value="{{$musteri->ad_soyad}}" class="form-control" maxlength="255" required/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Telefon
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="telefon" type="text" value="{{$musteri->telefon}}" maxlength="11" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Email
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="email" type="email" value="{{$musteri->email}}" maxlength="255" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Adres
							</label>
							<div class="col-md-9">
								<textarea name="adres" class="form-control" rows="5">{{$musteri->adres}}</textarea>
							</div>
						</div>
						
						
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" class="btn green">Kaydet | <i class="fa fa-save"></i></button>
							</div>
						</div>
					</div>
				</form>
				
			</div>
		</div>
	</div>


@endsection
