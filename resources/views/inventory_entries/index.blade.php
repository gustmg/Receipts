@extends('layouts.app')
@section('content')
<inventory-entries-component :user="{{Auth::user()}}"></inventory-entries-component>
@endsection