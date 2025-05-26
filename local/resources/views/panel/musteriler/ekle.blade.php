@extends('layouts.app')

@section('content')
	<!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Müşteri Ekle</h1>
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
            <span class="active">Müşteri Ekle</span>
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
				
				<form action="{{url('panel/musteriler/ekle')}}" id="form_islem" class="form-horizontal form-bordered" method="post">
					{!! csrf_field() !!}
					<div class="form-body">
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Tc
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="tc" type="text" value="{{old('tc')}}" maxlength="11" class="form-control" required>
							</div>
						</div>
						
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
								Telefon
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="telefon" type="text" value="{{old('telefon')}}" maxlength="11" class="form-control" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Email
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<input autocomplete="off" name="email" type="email" value="{{old('email')}}" maxlength="255" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">
								Adres
							</label>
							<div class="col-md-9">
								<textarea name="adres" class="form-control" rows="5">{{old('adres')}}</textarea>
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
