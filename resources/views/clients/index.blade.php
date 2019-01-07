@extends('layouts.app')
@section('content')
<div class="container">
<div class="row" style="margin-bottom: 0;">
	<div class="card hoverable col s12 m12" style="float: none;">
			<div class="input-field valign-wrapper" >
			<i class="material-icons prefix">search</i>
			<input placeholder="Buscar cliente" id="search_client" type="text" style="border-bottom: none!important;box-shadow: none!important;margin-bottom: 0;">
		</div>
	</div>
</div>
</div>
<div class="row">
    @if(count($clients)==0)
    	<h5 class="center grey-text">No hay clientes registrados.</h5>
	@else
		
    @endif
</div>
<a style="position:fixed;bottom: 24px;right: 24px;" class="btn-floating btn-large waves-effect waves-light modal-trigger" href="#newClientModal">
	<i class="material-icons">add</i>
</a>
@include('clients.newClientModal')
@endsection