@extends('layouts.app')
@section('content')

<a style="position:fixed;bottom: 24px;right: 24px;" class="btn-floating btn-large waves-effect waves-light modal-trigger" href="#newClientModal">
	<i class="material-icons">add</i>
</a>
<new-client-modal-component></new-client-modal-component>
<update-client-modal-component></update-client-modal-component>
<clients-component :clients="{{$clients}}"></clients-component>
@endsection