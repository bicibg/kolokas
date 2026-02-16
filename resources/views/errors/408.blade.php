@extends('errors.layout')

@php
  $error_number = 408;
@endphp

@section('title')
  Request timeout.
@endsection

@section('description')
  @php
    $default_error_message = "Please <a href='javascript:history.back()''>go back</a>, refresh the page and tru again.";

  @endphp
  @if(isset($exception) && $exception->getMessage())
    {{ $exception->getMessage() }}
  @else
    {!! $default_error_message !!}
  @endif
@endsection