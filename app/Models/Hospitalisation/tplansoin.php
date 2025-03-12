<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tplansoin extends Model
{
    protected $fillable=['id','refHospitaliser','refServiceSoin','datePlan','author'];
    protected $table = 'tplansoin';
}
