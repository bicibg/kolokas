@extends('layouts.app')

@section('content')
    @if(\App\Models\Profile::has('user.recipes', '>', 0)->count())
        <div class="container">
            @livewire('author-search-box', ['resultCount' => $authorsCount, 'extended' => true])
            <div class="row justify-content-center text-center">
                <div class="col-md-12">
                    <div class="heading">
                        <h3 class="section-title">{{ __('trx.authors') }}</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center m-2">
                @forelse($profiles as $profile)
                    <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
                        @livewire('author-box', ['profile'=>$profile])
                    </div>
                @empty
                    <span>{{ __('trx.no_profiles_found') }}</span>
                @endforelse
            </div>
            <div class="d-flex justify-content-center">
                {{ $profiles->withQueryString()->links() }}
            </div>
        </div>
    @endif
@endsection
