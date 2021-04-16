<div class="form-group col-md-12">
    <strong>{{ $field['label'] }}</strong> <br>
    <div class="dropzone sortable dz-clickable sortable">
        <div class="dz-message">
            Drop files here or click to upload.
        </div>

        @if ($entry->{$field['name']})
            @foreach($entry->{$field['name']} as $key => $image)
                <div class="dz-preview" data-id="{{ $image->id }}" data-path="{{ $image->url }}">
                    <img class="dropzone-thumbnail" src={{ $image->url }}>
                    <a class="dz-remove" href="javascript:void(0);" data-remove="{{ $image->id }}"
                       data-path="{{ $image->url }}">Remove file</a>
                </div>
            @endforeach
        @endif
    </div>
    <button type="button" class="btn btn-outline" onclick="dropzone.processQueue()">Apply</button>
</div>

@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}

    @push('crud_fields_styles')
        <style>
            .sortable {
                list-style-type: none;
                margin: 0;
                padding: 0;
                width: 100%;
                overflow: auto;
            }

            /*border: 1px SOLID #000;*/
            .sortable {
                margin: 3px 3px 3px 0;
                padding: 1px;
                float: left; /*width: 120px; height: 120px;*/
                vertical-align: bottom;
                text-align: center;
            }

            .dropzone-thumbnail {
                width: 115px;
                cursor: move !important;
            }

            .dz-preview {
                cursor: move !important;
            }
        </style>
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}

    @push('crud_fields_scripts')

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
        <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

        <script>
            Dropzone.autoDiscover = false;
            var uploaded = false;

            var dropzone = new Dropzone(".dropzone", {
                url: "{{ url('/recipes/'.$entry->slug.'/images') }}",
                maxFiles: 5,
                paramName: '{{ $field['name'] }}',
                uploadMultiple: true,
                acceptedFiles: "{{ $field['mimes'] }}",
                addRemoveLinks: true,
                // autoProcessQueue: false,
                maxFilesize: {{ $field['filesize'] }},
                parallelUploads: 10,
                // previewTemplate:
                sending: function (file, xhr, formData) {
                    formData.append("_token", $('[name=_token').val());
                    formData.append("id", {{ $entry->id }});
                },
                error: function (file, response) {
                    $(file.previewElement).find('.dz-error-message').remove();
                    $(file.previewElement).remove();

                    $(function () {
                        console.error(file.name + " was not uploaded!", response);
                    });

                },
                success: function (file, status) {
                    // clear the images in the dropzone
                    $('.dropzone').empty();

                    // repopulate the dropzone with all images (new and old)
                    $.each(status.images, function (key, image_path) {
                        $('.dropzone').append('<div class="dz-preview" data-id="' + key + '" data-path="' + image_path + '"><img class="dropzone-thumbnail" src="' + image_path + '" /><a class="dz-remove" href="javascript:void(0);" data-remove="' + key + '" data-path="' + image_path + '">Remove file</a></div>');
                    });

                    var notification_type;

                    if (status.success) {
                        notification_type = 'success';
                    } else {
                        notification_type = 'error';
                    }

                    console.info(status.message);
                }
            });

            // Delete image
            $(document).on('click', '.dz-remove', function () {
                var image_id = $(this).data('remove');
                var image_path = $(this).data('path');

                $.ajax({
                    url: "{{ url('/recipes/deleteimage/') }}/" + image_id,
                    type: 'POST',
                })
                    .done(function (status) {
                        var notification_type;

                        if (status.success) {
                            notification_type = 'success';
                            $('div.dz-preview[data-id="' + image_id + '"]').remove();
                        } else {
                            notification_type = 'error';
                        }
                    });

            });
        </script>

    @endpush
@endif
