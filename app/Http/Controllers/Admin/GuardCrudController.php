<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GuardRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class GuardCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Guard::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/guard');
        CRUD::setEntityNameStrings('guard', 'guards');
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb();

        CRUD::field('password')->label('Password')->type('password');
    }

    public function store()
    {
        $this->passwordHandling();
        $response = $this->traitStore();
        return $response;
    }

    public function update()
    {
        $this->passwordHandling();
        $response = $this->traitUpdate();
        return $response;
    }

    public function passwordHandling()
    {
        $this->crud->setRequest($this->crud->validateRequest());

        $request = $this->crud->getRequest();

        if ($request->input('password')) {
            $request->request->set('password', bcrypt($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        $this->crud->setRequest($request);
        $this->crud->unsetValidation();

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(GuardRequest::class);
        CRUD::setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
