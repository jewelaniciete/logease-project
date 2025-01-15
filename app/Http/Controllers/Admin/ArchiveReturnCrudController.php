<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Retrun;
use App\Models\ArchiveReturn;
use App\Http\Requests\ArchiveReturnRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ArchiveReturnCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\ArchiveReturn::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/archive-return');
        CRUD::setEntityNameStrings('archive return', 'archive returns');
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

        CRUD::denyAccess(['show', 'update',]);
        $this->crud->addButtonFromModelFunction('line', 'restore_return', 'restoreReturn', 'end');

    }

    public function restore($id)
    {
        $restore = ArchiveReturn::find($id);
        if ($restore) {
            // Create a new return entry
            $archive = new Retrun;
            $archive->key_id = $restore->key_id;
            $archive->teacher_id = $restore->teacher_id;
            $archive->date = Carbon::now();

            $archive->save();

            $restore->delete();

            return redirect(backpack_url('retrun'))->with('success', 'Item restored successfully.');
        }

        return redirect()->back()->with('error', 'Item not found');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ArchiveReturnRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
