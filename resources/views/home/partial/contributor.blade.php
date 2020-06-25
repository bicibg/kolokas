<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="heading">
            <h2>Top Authors</h2>
        </div>
    </div>

    @foreach($contributors as $profile)
        <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-content-center">
            <contributor-box :profile="{{ $profile->toJson() }}"></contributor-box>
        </div>
    @endforeach
</div>


