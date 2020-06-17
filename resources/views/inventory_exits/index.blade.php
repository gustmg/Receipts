@extends('layouts.app')
@section('content')
<inventory-exits-component :user="{{Auth::user()}}"></inventory-exits-component>
@endsection