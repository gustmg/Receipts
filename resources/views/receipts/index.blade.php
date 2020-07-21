@extends('layouts.app')
@section('content')
<receipts-component :worker="{{Auth::user()}}"></receipts-component>
@endsection