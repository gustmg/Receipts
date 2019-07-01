@extends('layouts.app')
@section('content')
<receipts-component :receipts="{{$receipts}}" :services="{{$services}}" :clients="{{$clients}}" :worker="{{Auth::user()}}"></receipts-component>
@endsection