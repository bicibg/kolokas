<div class="card">
    <div class="card-body">
        <fieldset>
            <div class="form-row mb-2">
                <div class="col-md-12">
                    <label class="col-form-label" for="main_image">Main Photo:</label>
                    <div wire:loading.remove>
                        <input type="file" class="bg-none border-0 form-control" name="main_image"
                               id="main_image" wire:model.defer="main_image"/>
                    </div>
                    <div wire:loading wire:target="main_image">Uploading main image...</div>
                    @if(!empty($main_image))
                        <div class="user-image mb-3">
                            <div class="imgPreview">
                                @if(method_exists($main_image, 'temporaryUrl'))
                                    <img src="{{ $main_image->temporaryUrl() }}" alt="">
                                @else
                                    <img src="{{ $main_image->url }}" alt="">
                                @endif
                            </div>
                        </div>
                    @endif

                    <small id="imageHelp" class="footnote form-text text-muted font-italic">
                        This will be the main image for your recipe
                    </small>
                </div>
            </div>
            <div class="form-row mb-2">
                <div class="col-md-12">
                    <label class="col-form-label" for="images">Additional Photos:</label>
                    <div wire:loading.remove>
                        <input type="file" class="bg-none border-0 form-control" wire:model.defer="images"
                               multiple
                               id="images"/>
                    </div>
                    <div wire:loading wire:target="images">Uploading images...</div>
                    @if(!empty($images))
                        <div class="user-image mb-3">
                            <div class="imgPreview">
                                @foreach($images as $image)
                                    @if(method_exists($image,'temporaryUrl'))
                                        <img src="{{ $image->temporaryUrl() }}" alt="">
                                    @else
                                        <img src="{{ $image->url }}" alt="">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <small id="imagesHelp" class="footnote form-text text-muted font-italic">
                        You can upload more than one (max 5)
                    </small>
                </div>
            </div>
        </fieldset>
    </div>
</div>
