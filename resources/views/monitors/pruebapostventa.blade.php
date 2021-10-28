@extends('layouts.apppostventa')

@section('content')
@include('common.success')
@include('common.errors')
<input class="form-control form-control-sm" type="text"  id="consultaGeneralCelular" name="consultaGeneralCelular" value='{{$op}}'>
@endsection