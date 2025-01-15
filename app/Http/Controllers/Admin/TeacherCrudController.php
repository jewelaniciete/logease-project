<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TeacherRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class TeacherCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Teacher::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/teacher');
        CRUD::setEntityNameStrings('teacher', 'teachers');
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(TeacherRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        // Adding a dropdown list for a field with options from another table
        CRUD::field('department_id')->type('select')->entity('department')->model('App\Models\Department')->attribute('department_name')->label('Department');


    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
