@extends('layouts.app')

@section('content')
    @livewire('recipe-edit', ['recipe' => $recipe])
@endsection
