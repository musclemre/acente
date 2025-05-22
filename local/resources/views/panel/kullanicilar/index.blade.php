@extends('layouts.app')
	<link href="{{url('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />

@section('content')
	<!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Kullanıcı Listesi</h1>
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
            <span class="active">Kullanıcı Listesi</span>
        </li>
    </ul>
	
	<div class="portlet-title">
        <div class="actions">
        </div>
    </div>
	
	<div class="portlet-body">
		@if(Session::has('ok'))
			<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				<strong>{{Session::get('ok')}}</strong>
			</div>
		@endif
		<table id="users_table" class="table table-striped table-bordered table-hover table-checkable">
			<thead>
				<tr>
					<th>ID</th>
					<th>İsim</th>
					<th>Kullanıcı Adı</th>
					<th>Durum</th>
					<th>İşlemler</th>
				</tr>
			</thead>
		</table>
	</div>

@section("js")
	
	<script>
		$(document).ready(function(){
		
			$('#users_table').DataTable({
				  
				"order": [[ 0, "desc" ]],
				ajax: '{{url("panel/kullanicilar/ajax-table")}}',
				"columns": [
					{data: 'id', name: 'id'},
					{data: 'name', name: 'name'},
					{data: 'email', name: 'email'},
					{data: 'durums', name: 'durums'},
					{data: 'action', name: 'action', orderable: false, searchable: false}
				]
			});
		});
	</script>
@endsection


@endsection
