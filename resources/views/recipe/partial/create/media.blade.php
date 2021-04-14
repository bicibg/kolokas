<div class="card">
    <div class="card-body">
        <fieldset>
            <div class="form-row mb-2">
                <div class="col-md-12">
                    <label class="col-form-label" for="main_image">{{ __('trx.main_photo') }}:</label>
                    <div wire:loading.remove>
                        <input type="file" class="bg-none border-0 form-control" name="main_image"
                               id="main_image" wire:model.defer="main_image"/>
                    </div>
                    <div wire:loading wire:target="main_image">{{ __('trx.main_photo_uploading') }}</div>
                    @if(!empty($main_image) || !empty($existing_main_image))
                        <div class="user-image mb-3">
                            <div class="imgPreview">
                                @if($main_image)
                                    <img src="{{ $main_image->temporaryUrl() }}" alt="">
                                @else
                                    <img src="{{ $existing_main_image }}" alt="">
                                @endif
                            </div>
                        </div>
                    @endif

                    <small id="imageHelp" class="footnote form-text text-muted font-italic">
                        {{ __('trx.main_photo_helper') }}
                    </small>
                </div>
                <div class="col-md-12">
                    <label class="col-form-label"
                           for="images">{{ __('trx.additional_photos', ['value' => $maxNewImages]) }}:</label>
                    <div wire:loading.remove>
                        <input type="file" class="bg-none border-0 form-control" wire:model.defer="images"
                               multiple
                               id="images"/>
                    </div>
                    <div wire:loading wire:target="images">{{ __('trx.additional_photos_uploading') }}</div>
                    <div class="row">
                        @foreach($images as $image)
                            <div class="col-md-2 text-center">
                                <label>
                                    <img class="img-thumbnail img-responsive" src="{{ $image->temporaryUrl() }}" alt="">
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if (isset($recipe) && $recipe->images()->count())
                    <div class="col-md-12">
                        <label class="col-form-label" for="images">{{ __('trx.additional_photos_existing') }}:</label>
                    </div>
                    <div class="col-md-12 d-flex justify-content-between">
                        {{--                        <div class="row" wire:ignore>--}}
                        @foreach($recipe->images()->get() as $image)
                            <div>
                                <img class="img-thumbnail img-responsive" src="{{ $image->url }}" alt="">
                                <input wire:model="existing_images"
                                       type="checkbox"
                                       autocomplete="off"
                                       value="{{ $image->id }}">
                                {{$image->id}}
                                <i class="fa fa-check hidden"></i>
                            </div>
                        @endforeach
                        {{--                        </div>--}}
                    </div>
                @endif
            </div>
        </fieldset>
    </div>
</div>
