<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//
class thospitalisation extends Model
{
    protected $fillable=['id','refLit','refDetailCons','dateEntree','diagnosticEntree',
    'observations','dateHospi','refServiceHospi','serviceOrigine','TypeOrientationHosp','author','statutHospi'];
    protected $table = 'thospitalisation';
}
