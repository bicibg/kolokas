@extends('layouts.app')

@section('content')
    <livewire:recipes :key="rand()"/>
@endsection
