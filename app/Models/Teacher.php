<?php

namespace App\Models;

use App\Models\Barrow;
use App\Models\Retrun;
use App\Models\Department;
use App\Models\ArchiveBorrow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'teachers';

    protected $guarded = ['id'];
    protected $fillable = ['department_id', 'firstname', 'lastname', 'number', 'address'];

    protected static function booted(): void
    {
        static::created(function (Teacher $teacher) {

            $number = mt_rand(1000000000, 9999999999);

            $generatorPNG = new BarcodeGeneratorPNG();
            $image = $generatorPNG->getBarcode($number, $generatorPNG::TYPE_CODE_128);

            $name = $teacher->firstname . '_' . $teacher->lastname . '_' . $number . '.png'; // Unique file name
            $teacher->code = $number;

            // Save the barcode image in the 'public/barcodes' directory
            Storage::disk('public')->put('barcodes/' . $name, $image);

            $teacher->save();


        });

    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function barrows()
    {
        return $this->hasMany(Barrow::class);
    }

    public function returns(){
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
