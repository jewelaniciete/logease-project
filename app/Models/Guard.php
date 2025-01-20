<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guard extends Authenticatable
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'guards';
    protected $guarded = ['id'];
    protected $hidden = ['password'];

}
