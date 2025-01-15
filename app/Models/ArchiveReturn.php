<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveReturn extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'archive_returns';
    protected $guarded = ['id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function key()
    {
        return $this->belongsTo(Key::class);
    }

    public function restoreReturn($crud = false)
    {
        // Using route() to generate the correct URL with the 'id' parameter
        return '<a class="btn btn-sm btn-link" href="' . route('return.restore', ['id' => $this->id]) . '" data-toggle="tooltip" title="Restore this item"><i class="la la-share"></i> Restore</a>';
    }

}
