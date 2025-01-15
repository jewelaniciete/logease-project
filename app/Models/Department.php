<?php

namespace App\Models;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'departments';
    protected $guarded = ['id'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
