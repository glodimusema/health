<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdetailsortiehospitaliser extends Model
{
    protected $fillable=['id','refSortriHospi','refServiceHospi','nombreJour','autreDetails','author'];
    protected $table = 'tdetailsortiehospitaliser';
}
