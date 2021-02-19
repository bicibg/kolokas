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
                    @if(!empty($main_image) || !empty($existing_main_image))
                        <div class="user-image mb-3">
                            <div class="imgPreview">
                                @if($main_image)
                                    <img src="{{ $main_image->temporaryUrl() }}" alt="">
                                @else
                                    <img src="{{ $existing_main_image->url }}" alt="">
                                @endif
                            </div>
                        </div>
                    @endif

                    <small id="imageHelp" class="footnote form-text text-muted font-italic">
                        This will be the main image for your recipe
                    </small>
                </div>
                <div class="col-md-12">
                    <label class="col-form-label" for="images">Additional Photos (max {{ $maxNewImages }}):</label>
                    <div wire:loading.remove>
                        <input type="file" class="bg-none border-0 form-control" wire:model.defer="images"
                               multiple
                               id="images"/>
                    </div>
                    <div wire:loading wire:target="images">Uploading images...</div>
                    <div class="row">
                        @foreach($images as $image)
                            <div class="col-md-2 text-center">
                                <label class="image-checkbox">
                                    <img class="img-thumbnail img-responsive" src="{{ $image->temporaryUrl() }}" alt="">
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if ($recipe && $recipe->images()->whereMain(false)->count())
                    <div class="col-md-12">
                        <label class="col-form-label" for="images">Existing Photos (uncheck to remove):</label>
                        <div class="row" wire:ignore>
                            @foreach($recipe->images()->whereMain(false)->get() as $image)
                                @if ($image->main) @continue @endif
                                <div class="col-md-2 text-center">
                                    <label class="">
                                        <img class="img-thumbnail img-responsive" src="{{ $image->url }}" alt="">
                                        <input wire:model="existing_images"
                                               type="checkbox"
                                               autocomplete="off"
                                               value="{{ $image->id }}">
                                        <i class="fa fa-check hidden"></i>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </fieldset>
    </div>
</div>
