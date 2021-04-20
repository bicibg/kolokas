<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation {
        show as traitShow;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    public function show($id)
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn([
            'label' => "Name",
            'type' => "text",
            'name' => 'profile.name',
        ]);
        CRUD::column('email');

        $this->crud->addColumn([
            'label' => "Slug",
            'type' => "text",
            'name' => 'profile.slug',
        ]);

        $this->crud->addColumn([
            'label' => "Info",
            'type' => "text",
            'name' => 'profile.info',
        ]);
        $this->crud->addColumn([
            'label' => "City",
            'type' => "text",
            'name' => 'profile.city',
        ]);
        $this->crud->addColumn([
            'label' => "Web",
            'type' => "text",
            'name' => 'profile.website',
        ]);
        $this->crud->addColumn([
            'label' => "Tel",
            'type' => "text",
            'name' => 'profile.telephone',
        ]);
        $this->crud->addColumn([
            'label' => "Facebook",
            'type' => "text",
            'name' => 'profile.facebook',
        ]);
        $this->crud->addColumn([
            'label' => "Instagram",
            'type' => "text",
            'name' => 'profile.instagram',
        ]);
        $this->crud->addColumn([
            'label' => "Pinterest",
            'type' => "text",
            'name' => 'profile.pinterest',
        ]);
        $this->crud->addColumn([
            'label' => "Twitter",
            'type' => "text",
            'name' => 'profile.twitter',
        ]);
        $this->crud->addColumn([
            'label' => "Pro",
            'type' => "boolean",
            'name' => 'profile.is_pro',
        ]);
        $this->crud->addColumn([
            'label' => "Restaurant",
            'type' => "boolean",
            'name' => 'profile.is_rastaurant',
        ]);
        $this->crud->addColumn([
            'label' => "Top",
            'type' => "boolean",
            'name' => 'profile.is_top',
        ]);
        $this->crud->addColumn([
            'label' => "Created at",
            'type' => "datetime",
            'name' => 'profile.created_at',
        ]);
        $this->crud->addColumn([
            'label' => "Updated at",
            'type' => "datetime",
            'name' => 'profile.updated_at',
        ]);
        $content = $this->traitShow($id);

        return $content;

    }

    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());

        /** @var \Illuminate\Http\Request $request */
        $request = $this->crud->getRequest();
        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        if ($request->input('email')) {
            $profile = $request->request->get('profile');
            $profile['email'] = $request->input('email');
            $request->request->set('profile', $profile);
        }
        $this->crud->setRequest($request);
        $this->crud->unsetValidation(); // Validation has already been run

        return $this->traitStore();
    }

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());

        /** @var \Illuminate\Http\Request $request */
        $request = $this->crud->getRequest();
        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        if ($request->input('email')) {
            if (in_array($this->crud->getEntry($request->request->get('id'))->email, ['bugraergin@gmail.com', 'burakergin95@gmail.com'])) {
                $request->request->remove('email');
            } else {
                $request->request->set('profile.email', $request->input('email'));
            }
        }

        $this->crud->setRequest($request);
        $this->crud->unsetValidation(); // Validation has already been run

        return $this->traitUpdate();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addButtonFromModelFunction('line', 'url', 'getUrlWithLink', 'beginning');

        $this->crud->addColumn([
            'label' => "Name",
            'type' => "select",
            'name' => 'user_id', // the column that contains the ID of that connected entity;
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Profile",
        ]);
        CRUD::column('email');

        $this->crud->addColumn([
            'label' => "# Recipes",
            'type' => "relationship_count",
            'name' => 'recipes',
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserCreateRequest::class);

        $this->crud->addField([
            'label' => "Email",
            'type' => "email",
            'name' => 'email',
        ]);
        $this->crud->addField([
            'type' => "hidden",
            'name' => 'profile.email',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "email", // foreign key attribute that is shown to user
        ]);
        CRUD::field('password');

        $this->crud->addField([
            'label' => "Name",
            'type' => "text",
            'name' => 'name',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
        ]);

        $this->crud->addField([
            'label' => "Info",
            'type' => "text",
            'name' => 'profile.info',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "info", // foreign key attribute that is shown to user
        ]);

        $this->crud->addField([
            'label' => "City",
            'type' => "text",
            'name' => 'profile.city',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "city", // foreign key attribute that is shown to user
        ]);
        $this->crud->addField([
            'label' => "Web",
            'type' => "url",
            'name' => 'profile.website',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "website", // foreign key attribute that is shown to user
        ]);
        $this->crud->addField([
            'label' => "Tel",
            'type' => "text",
            'name' => 'profile.telephone',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "telephone", // foreign key attribute that is shown to user
        ]);
        $this->crud->addField([
            'label' => "Facebook",
            'type' => "url",
            'name' => 'profile.facebook',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "facebook", // foreign key attribute that is shown to user
        ]);
        $this->crud->addField([
            'label' => "Instagram",
            'type' => "url",
            'name' => 'profile.instagram',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "instagram", // foreign key attribute that is shown to user
        ]);
        $this->crud->addField([
            'label' => "Pinterest",
            'type' => "url",
            'name' => 'profile.pinterest',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "pinterest", // foreign key attribute that is shown to user
        ]);
        $this->crud->addField([
            'label' => "Twitter",
            'type' => "url",
            'name' => 'profile.twitter',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "twitter", // foreign key attribute that is shown to user
        ]);
        $this->crud->addField([
            'label' => "Pro",
            'type' => "boolean",
            'name' => 'profile.is_pro',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "is_pro", // foreign key attribute that is shown to user
        ]);
        $this->crud->addField([
            'label' => "Restaurant",
            'type' => "boolean",
            'name' => 'profile.is_rastaurant',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "is_restaurant", // foreign key attribute that is shown to user
        ]);
        $this->crud->addField([
            'label' => "Top",
            'type' => "boolean",
            'name' => 'profile.is_top',
            'entity' => 'profile', // the method that defines the relationship in your Model
            'attribute' => "is_top", // foreign key attribute that is shown to user
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        CRUD::setValidation(UserUpdateRequest::class);
    }

    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCreateRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/create', [
            'as' => $routeName . '.admin-create',
            'uses' => $controller . '@create',
            'operation' => 'create',
        ]);

        Route::post($segment, [
            'as' => $routeName . '.admin-store',
            'uses' => $controller . '@store',
            'operation' => 'create',
        ]);
    }

    /**
     * Define which routes are needed for this operation.
     *
     * @param string $name Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupUpdateRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/{id}/edit', [
            'as' => $routeName . '.admin-edit',
            'uses' => $controller . '@edit',
            'operation' => 'update',
        ]);

        Route::put($segment . '/{id}', [
            'as' => $routeName . '.admin-update',
            'uses' => $controller . '@update',
            'operation' => 'update',
        ]);
    }

    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupShowRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/{id}/show', [
            'as' => $routeName . '.admin-show',
            'uses' => $controller . '@show',
            'operation' => 'show',
        ]);
    }

    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupListRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/', [
            'as' => $routeName . '.admin-index',
            'uses' => $controller . '@index',
            'operation' => 'list',
        ]);

        Route::post($segment . '/search', [
            'as' => $routeName . '.admin-search',
            'uses' => $controller . '@search',
            'operation' => 'list',
        ]);

        Route::get($segment . '/{id}/details', [
            'as' => $routeName . '.showDetailsRow',
            'uses' => $controller . '@showDetailsRow',
            'operation' => 'list',
        ]);
    }

    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupDeleteRoutes($segment, $routeName, $controller)
    {
        Route::delete($segment . '/{id}', [
            'as' => $routeName . '.admin-destroy',
            'uses' => $controller . '@destroy',
            'operation' => 'delete',
        ]);
    }
}
