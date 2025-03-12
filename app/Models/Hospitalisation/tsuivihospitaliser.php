<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsuivihospitaliser extends Model
{
    protected $fillable=['id','refHospitaliser','dateDetail','observationsInfirmier','moment','author'];
    protected $table = 'tsuivihospitaliser';
}
