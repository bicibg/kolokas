@if ($crud->hasAccess('create'))
	<a href="{{ url($crud->route.'/create?locale=el') }}" class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> {{ trans('backpack::crud.add') }} {{ $crud->entity_name }} (el)</span></a>
@endif
