@extends('layouts.app')
@section('content')
<reports-component :sales="{{$sales}}" :worker="{{Auth::user()}}"></reports-component>
@endsection