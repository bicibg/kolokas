@if ($crud->hasAccess('create'))
	<a href="{{ url($crud->route.'/create?locale=tr') }}" class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> {{ trans('backpack::crud.add') }} {{ $crud->entity_name }} (tr)</span></a>
@endif
