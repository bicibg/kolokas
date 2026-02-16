@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@@type": "ListItem",
            "position": 1,
            "name": "{{ __('trx.home') }}",
            "item": "{{ route('home') }}"
        }
        @if(isset($breadcrumbs))
            @foreach($breadcrumbs as $crumb)
            ,{
                "@@type": "ListItem",
                "position": {{ $loop->iteration + 1 }},
                "name": @json($crumb['name']),
                "item": @json($crumb['url'])
            }
            @endforeach
        @endif
    ]
}
</script>
@endpush
