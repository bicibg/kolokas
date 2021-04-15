@if($contributors->count())
    <div class="container pt-0 pt-sm-5 no-print">
        <div class="row justify-content-center m-2">
            @if(!empty($title))
                <div class="col-md-12">
                    <div class="heading">
                        <h2>{{ $title }}</h2>
                    </div>
                </div>
            @endif
            @foreach($contributors as $profile)
                <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
                    @livewire('author-box', ['profile' => $profile])
                </div>
            @endforeach
        </div>
    </div>
@endif
