<?php

namespace App\Models;

use App\Models\Barrow;
use App\Models\Retrun;
use App\Models\ArchiveBorrow;
use App\Models\ArchiveReturn;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Key extends Model
{
    use CrudTrait;
    use HasFactory;


    protected $table = 'keys';

    protected $guarded = ['id'];

    public function barrows()
    {
        return $this->hasMany(Barrow::class);
    }

    public function returns()
    {
        return $this->hasMany(Retrun::class);
    }

    public function archiveBarrows()
    {
        return $this->hasMany(ArchiveBorrow::class);
    }

    public function archiveReturn()
    {
        return $this->hasMany(ArchiveReturn::class);
    }
}
