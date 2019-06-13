@extends('layouts.app')
@section('content')
<receipts-component :receipts="{{$receipts}}" :services="{{$services}}" :clients="{{$clients}}"></receipts-component>
@endsection