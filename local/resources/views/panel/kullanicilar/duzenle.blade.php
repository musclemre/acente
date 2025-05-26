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
				@if(Session::has('ok'))
					<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
						<strong>{{Session::get('ok')}}</strong>
					</div>
				@endif
				<form action="{{url('panel/kullanicilar/duzenle',$kullanici->id)}}" id="form_islem" class="form-horizontal form-bordered" method="post">
					{!! csrf_field() !!}
					<div class="form-body">
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Ad Soyad
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="name" type="text" value="{{$kullanici->name}}" class="form-control" maxlength="255" required/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Kullanıcı Adı
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="email" type="email" value="{{$kullanici->email}}" class="form-control" maxlength="255" required/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Şifre
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input id="password" name="password" type="password" class="form-control" minlength="6"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">
								Telefon
							</label>
								<div class="col-md-9">
									<input autocomplete="off" name="telefon" type="text" value="{{$kullanici->telefon}}" maxlength="11" class="form-control" required >
								</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Tam Kullanıcı Yetkisi 
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
							
								<select id="full_yetki" class="form-control" name="full_yetki">
									<option {{ ($kullanici->full==1 ? '' : 'selected') }} value="0">Kısıtlı Yetki</option>
									<option {{ ($kullanici->full==1 ? 'selected' : '') }} value="1">Tam Yetkili</option>
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
									
										@foreach($moduller as $d)
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_{{$d->id}}"> {{$d->baslik}} </a></h4>
											</div>
											<div id="collapse_{{$d->id}}" class="panel-collapse collapse show">
												<div class="panel-body">
													<div class="mt-checkbox-inline">
														@for($m = 1; $m < 10; $m++)
														<?php $veri="y".$m;?>
														@if($d->$veri)
															<label class="mt-checkbox mt-checkbox-outline"> {{$d->$veri}}
															<input id="{{$d->prefix}}_y{{$m}}" type="checkbox" value="y{{$m}}" name="{{$d->prefix}}[]" />
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
	
	@foreach($modul as $m)
		@if($m->y1==1)$('#{{$m->modul}}_y1').attr('checked',true);@endif
		@if($m->y2==1)$('#{{$m->modul}}_y2').attr('checked',true);@endif
		@if($m->y3==1)$('#{{$m->modul}}_y3').attr('checked',true);@endif
		@if($m->y4==1)$('#{{$m->modul}}_y4').attr('checked',true);@endif
		@if($m->y5==1)$('#{{$m->modul}}_y5').attr('checked',true);@endif
		@if($m->y6==1)$('#{{$m->modul}}_y6').attr('checked',true);@endif
		@if($m->y7==1)$('#{{$m->modul}}_y7').attr('checked',true);@endif
		@if($m->y8==1)$('#{{$m->modul}}_y8').attr('checked',true);@endif
		@if($m->y9==1)$('#{{$m->modul}}_y9').attr('checked',true);@endif
		@if($m->y10==1)$('#{{$m->modul}}_y10').attr('checked',true);@endif
	@endforeach
	
</script>
@endsection

@endsection


