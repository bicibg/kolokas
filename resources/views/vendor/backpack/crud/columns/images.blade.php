{{-- image column type --}}
@php
    $images = $entry->images;
    if ($images->count()) {
        $column['height'] = $column['height'] ?? "25px";
        $column['width'] = $column['width'] ?? "auto";
        $column['radius'] = $column['radius'] ?? "3px";

        $column['wrapper']['element'] = $column['wrapper']['element'] ?? 'a';
        $column['wrapper']['target'] = $column['wrapper']['target'] ?? '_blank';
    }
@endphp

<span>
  @if( !$images->count() )
        -
    @else
        <div class="row">
            @foreach($images as $image)
                <div class="col-md-2 text-center">
                    @php
                        $href = asset($image->url);
                        $column['wrapper']['href'] = $column['wrapper']['href'] ?? $href ?? '';
                    @endphp
                    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
                        <img class="img-thumbnail img-responsive" src="{{ $image->url }}" alt="">
                    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
                </div>
            @endforeach
        </div>
    @endif
</span>
