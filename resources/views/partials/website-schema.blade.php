@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebSite",
    "name": "Kolokas",
    "url": "https://kolokas.com",
    "inLanguage": ["en", "tr", "el"],
    "potentialAction": {
        "@@type": "SearchAction",
        "target": "https://kolokas.com/recipes?s={search_term_string}",
        "query-input": "required name=search_term_string"
    }
}
</script>
@endpush
