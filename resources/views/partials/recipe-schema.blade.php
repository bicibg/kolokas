@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Recipe",
    "name": @json($recipe->title),
    "description": @json(\Illuminate\Support\Str::limit($recipe->description ?: $recipe->instructions, 500, '...')),
    "url": @json($recipe->url),
    "author": {
        "@@type": "Person",
        "name": @json($recipe->author->name),
        "url": @json(route('profile.show', $recipe->author->profile))
    },
    "datePublished": "{{ $recipe->created_at->toIso8601String() }}",
    "dateModified": "{{ $recipe->updated_at->toIso8601String() }}",
    @if($recipe->main_image)
    "image": [
        @json($recipe->main_image)
        @foreach($recipe->images as $img)
        , @json(asset('storage/' . $img->getAttributes()['url']))
        @endforeach
    ],
    @endif
    @if($recipe->categories->count())
    "recipeCategory": @json($recipe->categories->pluck('name')->toArray()),
    @endif
    @if($recipe->prep_time)
    "prepTime": "PT{{ $recipe->prep_time }}M",
    @endif
    @if($recipe->cook_time)
    "cookTime": "PT{{ $recipe->cook_time }}M",
    @endif
    @if($recipe->prep_time || $recipe->cook_time)
    "totalTime": "PT{{ ($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0) }}M",
    @endif
    @if($recipe->servings)
    "recipeYield": @json($recipe->servings),
    @endif
    "recipeIngredient": @json($recipe->getIngredientsArray()->values()->toArray()),
    "recipeInstructions": [
        @foreach($recipe->getInstructionsArray() as $index => $step)
        {
            "@@type": "HowToStep",
            "position": {{ $loop->iteration }},
            "text": @json($step)
        }@if(!$loop->last),@endif
        @endforeach
    ],
    "publisher": {
        "@@type": "Organization",
        "name": "Kolokas",
        "url": "https://kolokas.com",
        "logo": {
            "@@type": "ImageObject",
            "url": "{{ asset('images/kolokas_fb.png') }}"
        }
    }
}
</script>
@endpush
