@extends('layouts.app')
@section('content')
<sales-component :sales="{{$sales}}" :services="{{$services}}" :products="{{$products}}" :clients="{{$clients}}" :worker="{{Auth::user()}}"></sales-component>
@endsection