<?php

namespace App\Models;

use App\Models\Key;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Retrun extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'returns';
    protected $guarded = ['id'];

    public function archiveReturn($crud = false)
    {
        // Using route() to generate the correct URL with the 'id' parameter
        return '<a class="btn btn-sm btn-link" href="' . route('return.soft_delete', ['id' => $this->id]) . '" data-toggle="tooltip" title="Archive this item"><i class="la la-external-link"></i> Archive</a>';
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function key()
    {
        return $this->belongsTo(Key::class);
    }
}
