<div class="row justify-content-center m-2">
    <div class="col-md-12">
        <div class="heading">
            <h2>{{ __('home.top_authors') }}</h2>
        </div>
    </div>

    @foreach($contributors as $profile)
        <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
            @livewire('author-box', ['profile' => $profile])
        </div>
    @endforeach
</div>


