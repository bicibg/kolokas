@extends('errors.layout')

@php
	$error_number = 500;
@endphp

@section('title')
	It's not you, it's me.
@endsection

@section('description')
	@php
	  $default_error_message = "An internal server error has occurred. If the error persists please contact the development team.";
	@endphp
	@if(isset($exception) && $exception->getMessage())
	  {{ $exception->getMessage() }}
	@else
	  {!! $default_error_message !!}
	@endif
@endsection