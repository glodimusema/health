<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmaladiechronique extends Model
{
    protected $fillable=['id','refMalade','refmaladie','autredetail','author'];
    protected $table = 'tmaladiechronique';
}
