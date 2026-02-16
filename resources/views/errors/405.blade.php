@extends('errors.layout')

@php
  $error_number = 405;
@endphp

@section('title')
  Method not allowed.
@endsection

@section('description')
  @php
    $default_error_message = "Please <a href='javascript:history.back()''>go back</a> or return to <a href='".url('')."'>our homepage</a>.";
  @endphp
  @if(isset($exception) && $exception->getMessage())
    {{ $exception->getMessage() }}
  @else
    {!! $default_error_message !!}
  @endif
@endsection