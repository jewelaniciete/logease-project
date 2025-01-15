<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\KeyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class KeyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Key::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/key');
        CRUD::setEntityNameStrings('key', 'keys');
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(KeyRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
