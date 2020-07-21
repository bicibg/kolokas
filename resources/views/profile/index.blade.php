@extends('layouts.app')

@section('content')
    <div class="container">
        @livewire('author-search-box', ['resultCount' => $authorsCount, 'extended' => true])
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <div class="heading">
                    <h3 class="section-title">{{ __('nav.authors') }}</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @forelse($profiles as $profile)
                <div class="col-md-3 col-sm-4 d-flex align-items-stretch">
                    @livewire('author-box', ['profile'=>$profile])
                </div>
            @empty
                <span>{{ __('profile.no_profiles_found') }}</span>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            {{ $profiles->withQueryString()->links() }}
        </div>
    </div>
@endsection
