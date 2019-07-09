@extends('layouts.app')
@section('content')
<products-component :products="{{$products}}"></products-component>
@endsection