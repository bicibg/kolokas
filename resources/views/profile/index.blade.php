@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        @include('profile.partial.search-extended')
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <h3 class="section-title">{{ __('nav.authors') }}</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            @if($count)
                <div class="col-lg-12">
                    <h5 class="text-center">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                        {{ trans_choice('profile.profiles_found', $count, ['number' => $count]) }}
                    </h5>
                </div>
            @endif
            @forelse($profiles as $profile)
                <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
                    @livewire('author-box', ['profile'=>$profile])
                </div>
            @empty
                {{ __('profile.no_profiles_found') }}
            @endforelse
        </div>
        {{ $profiles->links() }}
    </div>
@endsection
