@extends('layouts.app')
@section('content')
<clients-component :clients="{{$clients}}"></clients-component>
@endsection