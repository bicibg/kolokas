<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RecipeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation {show as traitShow;}

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
        $this->crud->denyAccess('create');

    }

    public function show($id)
    {
        // custom logic before
        $this->crud->set('show.setFromDb', false);

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
        CRUD::column('published');
        CRUD::column('traditional');
        CRUD::column('featured');
        CRUD::column('created_at');
        CRUD::column('updated_at');

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
        CRUD::setValidation(RecipeRequest::class);

        $this->crud->addField([
            'label' => "User",
            'type' => "select",
            'name' => 'user_id', // the column that contains the ID of that connected entity;
            'entity' => 'author', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\User",
        ]);
        CRUD::field('title');
        CRUD::field('ingredients');
        CRUD::field('instructions');
        CRUD::field('description');
        $this->crud->addField([
            'name' => 'prep_time',
            'label' => 'Prep Time (in minutes)'
        ]);
        $this->crud->addField([
            'name' => 'cook_time',
            'label' => 'Cook Time (in minutes)'
        ]);
        CRUD::field('servings');
        CRUD::field('featured');
        CRUD::field('traditional');
        CRUD::field('published');

//        $text = '';
//        foreach($this->crud->fields()['instructions'] as $instruction){
//            $text .= $instruction . '\n';
//        }
//        $this->crud->modifyField('instructions', ['value' => $text]);
//        $text = '';
//
//        foreach($this->crud->fields()['ingredients'] as $ingredient){
//            $text .= $ingredient . '\n';
//        }
//        $this->crud->modifyField('ingredients', ['value' => $text]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
//                $text = '';
//        foreach($this->crud->fields()['instructions']['value'] as $instruction){
//            $text .= $instruction . '\n';
//        }
//        $this->crud->modifyField('instructions', ['value' => $text]);
//        $text = '';
//
//        foreach($this->crud->fields()['ingredients']['value'] as $ingredient){
//            $text .= $ingredient . '\n';
//        }
//        $this->crud->modifyField('ingredients', ['value' => $text]);
    }

}
