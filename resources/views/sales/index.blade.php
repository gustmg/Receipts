@extends('layouts.app')
@section('content')
<sales-component :services="{{$services}}" :products="{{$products}}" :clients="{{$clients}}" :worker="{{Auth::user()}}"></sales-component>
@endsection