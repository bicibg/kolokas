@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 title text-center">
                <h1>{{ __('nav.contact_us') }}</h1>
            </div>
            <div class="col-lg-8 content">
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('general.contact.name') }}</label>
                        @include('partials.has-errors', ['field' => 'name'])
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->check() ? auth()->user()->name: '') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('general.contact.email') }}</label>
                        @include('partials.has-errors', ['field' => 'email'])
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->check() ? auth()->user()->email: '') }}">
                    </div>
                    <div class="form-group">
                        <label for="subject">{{ __('general.contact.subject') }}</label>
                        @include('partials.has-errors', ['field' => 'subject'])
                        <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}">
                    </div>
                    <div class="form-group">
                        <label for="user_message">{{ __('general.contact.message') }}</label>
                        @include('partials.has-errors', ['field' => 'user_message'])
                        <textarea class="form-control" rows="4" required="required" id="user_message" name="user_message">{{ old('user_message') }}</textarea>
                    </div>
                    <base-button :role="'submit'" :className="'btn-link p-0 m-0 align-baseline'">
                        {{ __('general.contact.send') }}
                    </base-button>
                </form>
            </div>
        </div>
    </div>
@endsection
