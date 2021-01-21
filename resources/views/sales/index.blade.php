@extends('layouts.app')
@section('content')
<sales-component :worker="{{Auth::user()}}"></sales-component>
@endsection