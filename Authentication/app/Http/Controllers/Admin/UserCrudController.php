<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Hash;
use Illuminate\Http\Request;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'Users');
        $this->crud->allowAccess(['delete']);

        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'name',
            'label' => 'Name',
          ],
          false,
          function($value) { // if the filter is active
            $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
          });
          $this->crud->addFilter([ // daterange filter
            'type' => 'date_range',
            'name' => 'created_at',
            'label'=> 'Date range'
            ],
            false,
            function($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
            });
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'label' => "Name",
            'name' => "name",
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'label' => "Email",
            'name' => "email",
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'label' => "Date Joined",
            'name' => "created_at",
            'type' => 'date',
        ]);
        // CRUD::column('password');

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
        CRUD::setValidation(UserRequest::class);

        // CRUD::field('name');
        $this->crud->addField([
            'label' => "Name",
            'name' => "name",
            'type' => 'text',
        ]);
        $this->crud->addField([
            'label' => "Email",
            'name' => "email",
            'type' => 'text',
        ]);
        $this->crud->addField([
            'label' => "Date Joined",
            'name' => "created_at",
            'type' => 'date',
        ]);

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
    }
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
            $this->crud->addColumn([
                'label' => "Name",
                'name' => "name",
                'type' => 'text',
            ]);
            $this->crud->addColumn([
                'label' => "Email",
                'name' => "email",
                'type' => 'text',
            ]);
            $this->crud->addColumn([
                'label' => "Date Joined",
                'name' => "created_at",
                'type' => 'date',
            ]);
            // CRUD::column('password');
    
            /**
             * Columns can be defined using the fluent syntax or array syntax:
             * - CRUD::column('price')->type('number');
             * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
             */
        
    }
    public function store(Request $request)
    {

        $this->crud->hasAccessOrFail('create');
        $request->offsetSet('password', Hash::make($request['password']));
        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
