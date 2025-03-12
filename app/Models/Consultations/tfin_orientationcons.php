<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_orientationcons extends Model
{
    protected $fillable=['id','refDetailCons','detailorientation','author'];
    protected $table = 'tfin_orientationcons';
}
