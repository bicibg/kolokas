@extends('layouts.app')

@php
  $title = 'Error '.$error_number;
@endphp

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12 text-center" style="padding: 80px 0;">
      <div style="font-size: 156px; font-weight: 600; line-height: 100px;">
        <small style="font-size: 56px; font-weight: 700;">ERROR</small><br>
        {{ $error_number }}
        <hr style="margin-top: 60px; margin-bottom: 0; width: 50px; display: inline-block;">
      </div>
      <div style="margin-top: 40px; font-size: 36px; font-weight: 400;" class="text-muted">
        @yield('title')
      </div>
      <div style="font-size: 24px; font-weight: 400;" class="text-muted">
        <small>
          @yield('description')
        </small>
      </div>
    </div>
  </div>
</div>
@endsection
