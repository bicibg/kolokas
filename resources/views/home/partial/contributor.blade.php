<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="heading">
            <h2>{{ __('home.top_authors') }}</h2>
        </div>
    </div>

    @foreach($contributors as $profile)
        <div class="col-md-3 col-sm-4 d-flex align-content-center">
            @livewire('author-box', ['profile' => $profile])
        </div>
    @endforeach
</div>


