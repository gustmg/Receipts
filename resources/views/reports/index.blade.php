@extends('layouts.app')
@section('content')
<reports-component :worker="{{Auth::user()}}"></reports-component>
@endsection