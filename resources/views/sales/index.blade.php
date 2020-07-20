@extends('layouts.app')
@section('content')
<sales-component :worker="{{Auth::user()}}"></sales-component>
<warning-product-cost-modal-component></warning-product-cost-modal-component>
@endsection