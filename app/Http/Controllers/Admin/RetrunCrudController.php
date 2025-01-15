<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Retrun;
use App\Models\ArchiveReturn;
use App\Http\Requests\RetrunRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class RetrunCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Retrun::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/retrun');
        CRUD::setEntityNameStrings('return', 'returns');
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        CRUD::modifyColumn('key_id',[
            'type' => 'custom_html',
            'value' => function ($entry) {
                return $entry->key?->key_name;
            }
        ]);

        CRUD::modifyColumn('teacher_id',[
            'type' => 'custom_html',
            'value' => function ($entry) {
                return $entry->teacher?->firstname . ' ' . $entry->teacher?->lastname;
            }
        ]);

        CRUD::denyAccess('delete');
        $this->crud->addButtonFromModelFunction('line', 'archive_return', 'archiveReturn', 'end');
    }

    public function soft_delete($id)
    {
        $return = Retrun::find($id);
        if ($return) {
            // Create a new return entry
            $archive = new ArchiveReturn;
            $archive->key_id = $return->key_id;
            $archive->teacher_id = $return->teacher_id;
            $archive->date = Carbon::now();

            $archive->save();

            $return->delete();

            return redirect(backpack_url('archive-return'))->with('success', 'archived successfully.');
        }

        return redirect()->back()->with('error', 'Item not found');
    }



    protected function setupCreateOperation()
    {
        CRUD::setValidation(RetrunRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
