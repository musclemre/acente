@extends('layouts.app')

@section('content')
	<!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Kullanıcı Ekle</h1>
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
            <span class="active">Kullanıcı Ekle</span>
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
				
				<form action="{{url('panel/kullanicilar/ekle')}}" id="form_islem" class="form-horizontal form-bordered" method="post">
					{!! csrf_field() !!}
					<div class="form-body">
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Ad Soyad
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="name" type="text" value="{{old('name')}}" class="form-control" maxlength="255" required/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Kullanıcı Adı
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="email" type="email" value="{{old('email')}}" class="form-control" maxlength="255" required/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Şifre
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input id="password" name="password" type="password" class="form-control" minlength="6" required/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">
								Telefon
							</label>
								<div class="col-md-9">
									<input autocomplete="off" name="telefon" type="text" value="{{old('telefon')}}" maxlength="11" class="form-control">
								</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Tam Kullanıcı Yetkisi
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
							
							<select id="full_yetki" class="form-control" name="full_yetki">
								<option value="0" selected>Kısıtlı Yetki</option>
								<option value="1">Tam Yetkili</option>
							</select>
							
							</div>
						</div>
						
						<div id="d_kategori">
							<div class="form-group">
								<label class="control-label col-md-3">
									Modüller 
									<span class="required"> * </span>
								</label>
								<div class="col-md-9">
								
									<div class="panel-group accordion" id="accordion1" style="margin: 0">
									
										@foreach($data as $d)
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_{{$d->id}}"> {{$d->baslik}} </a></h4>
											</div>
											<div id="collapse_{{$d->id}}" class="panel-collapse collapse">
												<div class="panel-body">
												
													<div class="mt-checkbox-inline">
														@for($m = 1; $m < 6; $m++)
														<?php $veri="y".$m;?>
														@if($d->$veri)
														<label class="mt-checkbox mt-checkbox-outline"> {{$d->$veri}}
														<input type="checkbox" value="y{{$m}}" name="{{$d->prefix}}[]" />
														<span></span>
														</label>
														@endif
														@endfor
													
													</div>
												</div>
											</div>
										</div>
										@endforeach
									
									</div>
								</div>
							</div>
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

			
@section("js")
<script>
	$('#full_yetki').on('change', function(e) {
	
		if($("#full_yetki").val()==1){
			$("#d_kategori" ).hide(500);
		} else {
			$("#d_kategori" ).show(500);
		}
	
	});
</script>
@endsection

@endsection
