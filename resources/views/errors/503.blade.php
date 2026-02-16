@extends('errors.layout')

@php
  $error_number = 503;
@endphp

@section('title')
  It's not you, it's me.
@endsection

@section('description')
  @php
    $default_error_message = "The server is overloaded or down for maintenance. Please try again later.";
  @endphp
  @if(isset($exception) && $exception->getMessage())
    {{ $exception->getMessage() }}
  @else
    {!! $default_error_message !!}
  @endif
@endsection
