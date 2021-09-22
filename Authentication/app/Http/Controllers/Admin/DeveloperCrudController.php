<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DeveloperRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Hash;
use Illuminate\Http\Request;
/**
 * Class DeveloperCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DeveloperCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Developer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/developer');
        CRUD::setEntityNameStrings('developer', 'developers');
        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'first_name',
            'label' => 'First Name',
          ],
          false,
          function($value) { // if the filter is active
            $this->crud->addClause('where', 'first_name', 'LIKE', "%$value%");
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
            'label' => "First Name",
            'name' => "first_name",
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'label' => "Profile Image",
            'name' => "image",
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);
        // $this->crud->addColumn([
        //     'label' => "Last Name",
        //     'name' => "last_name",
        //     'type' => 'text',
        // ]);
        $this->crud->addColumn([
            'label' => "Phone",
            'name' => "phone",
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'label' => "Address",
            'name' => "address",
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'label' => "Email",
            'name' => "email",
            'type' => 'text',
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
    CRUD::setValidation(DeveloperRequest::class);

    // CRUD::field('name');
   
    $this->crud->addField([
        'label' => "First Name",
        'name' => "first_name",
        'type' => 'text',
    ]);
    $this->crud->addField([
        'label' => "Last Name",
        'name' => "last_name",
        'type' => 'text',
    ]);
    $this->crud->addField([
        'label' => "Phone",
        'name' => "phone",
        'type' => 'text',
    ]);
    $this->crud->addField([
        'label' => "Address",
        'name' => "address",
        'type' => 'text',
    ]);
    $this->crud->addField([
        'label' => "Email",
        'name' => "email",
        'type' => 'text',
    ]);
    $this->crud->addField([
        'label' => "Password",
        'name' => "password",
        'type' => 'password',
    ]);
    $this->crud->addField([
        'label' => "Profile Image",
        'name' => "image",
        'type' => 'image',
        'crop' => true, // set to true to allow cropping, false to disable
        'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
        // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
        // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
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
                'label' => "First Name",
                'name' => "first_name",
                'type' => 'text',
            ]);
            $this->crud->addColumn([
                'label' => "Profile Image",
                'name' => "image",
                'type' => 'image',
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);
            $this->crud->addColumn([
                'label' => "Last Name",
                'name' => "last_name",
                'type' => 'text',
            ]);
            $this->crud->addColumn([
                'label' => "Phone",
                'name' => "phone",
                'type' => 'text',
            ]);
            $this->crud->addColumn([
                'label' => "Address",
                'name' => "address",
                'type' => 'text',
            ]);
            $this->crud->addColumn([
                'label' => "Email",
                'name' => "email",
                'type' => 'text',
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
