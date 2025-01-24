<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Key;
use App\Models\Barrow;
use App\Models\Retrun;
use App\Models\ArchiveBorrow;
use App\Http\Requests\BarrowRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class BarrowCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Barrow::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/barrow');
        CRUD::setEntityNameStrings('borrow', 'borrows');
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

        CRUD::modifyColumn('status', [
            'type' => 'custom_html',
            'value' => function ($entry) {
                if ($entry->status == 'returned') {
                    CRUD::denyAccess('show');
                }
                return $entry->status;
            }
        ]);
        CRUD::denyAccess('create');
        CRUD::denyAccess('delete');
        $this->crud->addButtonFromModelFunction('line', 'archive_borrow', 'archiveBorrow', 'end');
    }

    protected function setupShowOperation()
    {
        CRUD::column('key_id', [
            'type' => 'custom_html',
            'value' => function ($entry) {
                return $entry->key?->key_name;
            }
        ]);

        $barrow_columns = [
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'number' => 'Number',
            'address' => 'Address',
        ];

        foreach ($barrow_columns as $attribute => $label) {
            CRUD::column([
                'label' => $label,
                'entity' => 'teacher',
                'attribute' => $attribute,
                'model' => 'App\Models\Teacher',
            ]);
        }

        // Fixing the button to use route() for proper URL generation
        $this->crud->addButtonFromModelFunction('line', 'open_google', 'return', 'beginning');
    }


    public function key_return($id)
    {
        $barrow = Barrow::find($id);

        if ($barrow) {
            // Create a new return entry
            $return = new Retrun;
            $return->key_id = $barrow->key_id;
            $return->teacher_id = $barrow->teacher_id;
            $return->date = Carbon::now();
            $return->save();

            // Update the status of the key table
            $key = Key::find($barrow->key_id);
            if ($key) {
                $key->status = 'returned'; // Update the status to 'returned' or any appropriate value
                $key->save();
            }

            // Update the status of the barrow table
            $barrow->status = 'returned'; // Update the status to 'returned' or any appropriate value
            $barrow->save();

            return redirect(backpack_url('retrun'))->with('success', 'Item status updated and transferred successfully.');
        }

        return redirect()->back()->with('error', 'Item not found');
    }

    public function soft_delete($id)
    {
        $barrow = \App\Models\Barrow::find($id);
        if ($barrow) {
            // Create a new return entry
            $archive = new ArchiveBorrow;
            $archive->key_id = $barrow->key_id;
            $archive->teacher_id = $barrow->teacher_id;
            $archive->status = $barrow->status;
            $archive->date = Carbon::now();

            $archive->save();

            $barrow->delete();

            return redirect(backpack_url('archive-borrow'))->with('success', 'archived successfully.');
        }

        return redirect()->back()->with('error', 'Item not found');
    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(BarrowRequest::class);

        // Dropdown field for key selection
        CRUD::field('key_id')
        ->type('select')
        ->entity('key')
        ->model('App\Models\Key')
        ->attribute('key_name')
        ->label('Key')
        ->options(function () {
            return Key::where('status', '!=', 'borrowed')->orWhereNull('status')->get();
        });

        // Barcode field to accept input
        CRUD::addField([
            'name' => 'barcode',
            'type' => 'text', // This will accept the scanned barcode
            'label' => 'Teacher Barcode',
            'attributes' => [
                'placeholder' => 'Scan the teacher’s barcode here',
            ],
        ]);

        // Hidden teacher_id field to store the corresponding teacher's ID
        CRUD::field('teacher_id')->type('hidden')->label('Teacher');

        // Override the saving process to set the teacher_id based on the barcode
        CRUD::getRequest()->merge([
            'teacher_id' => $this->getTeacherIdFromBarcode(CRUD::getRequest()->input('barcode'),CRUD::getRequest()->input('key_id')),
        ]);

        // Hidden date field
        CRUD::field('date')->type('hidden')->label('Date')->value(Carbon::now());
    }

    protected function getTeacherIdFromBarcode($barcode, $key_id)
    {
        Key::where('id', $key_id)->update(['status' => 'borrowed']);

        $teacher = \App\Models\Teacher::where('code', $barcode)->first();

        return $teacher ? $teacher->id : null;
    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
