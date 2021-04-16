<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RecipeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

/**
 * Class RecipeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RecipeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
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
        CRUD::setModel(\App\Models\Recipe::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/recipe');
        CRUD::setEntityNameStrings('recipe', 'recipes');
    }

    public function show($id)
    {
        // custom logic before
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn([ // image
            'label' => "Main Image",
            'name' => "main_image",
            'type' => 'image',
            'height' => '100px'
        ]);

        $this->crud->addColumn([
            'label' => "Other Images",
            'type' => "view",
            'attribute' => "url", // foreign key attribute that is shown to user
            'entity' => 'images', // the method that defines the relationship in your Model
            'name' => "recipe_id",
            'model' => "App\Models\RecipeImage",
            'view' => 'backpack::crud.columns.images', // or path to blade file
        ]);

        CRUD::column('title');

        $this->crud->addColumn([
            'label' => "User",
            'type' => "select",
            'name' => 'user_id', // the column that contains the ID of that connected entity;
            'entity' => 'author', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\User",
        ]);

        $this->crud->addColumn([
            'label' => "Categories",
            'type' => "select_multiple",
            'name' => 'categories', // the column that contains the ID of that connected entity;
            'entity' => 'categories', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
        ]);

        $this->crud->addColumn([
            'name' => 'prep_time',
            'label' => 'Prep Time (in minutes)'
        ]);
        $this->crud->addColumn([
            'name' => 'cook_time',
            'label' => 'Cook Time (in minutes)'
        ]);
        CRUD::column('servings');
        CRUD::column('description');

        $this->crud->addColumn([
            'name' => 'ingredients',
            'escaped' => false,
            'type' => 'text',
            'limit' => 10000
        ]);
        $this->crud->addColumn([
            'name' => 'instructions',
            'escaped' => false,
            'type' => 'text',
            'limit' => 10000
        ]);
        $this->crud->addColumn([
            'name' => 'notes',
            'escaped' => false,
            'type' => 'text',
            'limit' => 10000
        ]);
        CRUD::column('published');
        CRUD::column('traditional');
        CRUD::column('featured');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        $content = $this->traitShow($id);

        // cutom logic after
        return $content;
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('title');

        $this->crud->addColumn([
            'label' => "User",
            'type' => "select",
            'name' => 'user_id', // the column that contains the ID of that connected entity;
            'entity' => 'author', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\User",
        ]);

        $this->crud->addColumn([
            'label' => "# Images",
            'type' => "relationship_count",
            'name' => 'images', // the method that defines the relationship in your Model
        ]);


        CRUD::column('published');
        CRUD::column('traditional');
        CRUD::column('featured');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(RecipeRequest::class);

        $this->crud->addField([ // image
            'label' => "Main Image",
            'name' => "main_image",
            'type' => 'image',
            'crop' => false,
            'aspect_ratio' => 0,
        ]);

        CRUD::field('title');

        $this->crud->addField([
            'label' => "User",
            'type' => "select",
            'name' => 'user_id', // the column that contains the ID of that connected entity;
            'entity' => 'author', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\User",
        ]);

        $this->crud->addField([
            'label' => "Categories",
            'type' => "select2_multiple",
            'name' => 'categories',
            'entity' => 'categories',
            'attribute' => "name",
            'model' => "App\Models\Category",
        ]);

        $this->crud->addField([
            'name' => 'prep_time',
            'label' => 'Prep Time (in minutes)'
        ]);
        $this->crud->addField([
            'name' => 'cook_time',
            'label' => 'Cook Time (in minutes)'
        ]);
        CRUD::field('ingredients');
        CRUD::field('instructions');
        CRUD::field('description');
        CRUD::field('notes');
        CRUD::field('prep_time');
        CRUD::field('cook_time');
        CRUD::field('servings');
        CRUD::field('main_image');
        CRUD::field('featured');
        CRUD::field('traditional');
        CRUD::field('published');
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
        $this->crud->addField([
            'label' => "Other Images",
            'type' => "dropzone",
            'name' => 'images',
            'fake' => true,
            'mimes' => '.jpg,.jpeg,.png',
            'filesize' => '5000'
        ])->afterField('main_image');
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
