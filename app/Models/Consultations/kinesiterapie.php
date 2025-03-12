<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kinesiterapie extends Model
{
    protected $fillable=['id','refDetailCons','observationmedesin','nombreseance','commentaire','statutkine','author'];
    protected $table = 'kinesiterapie';
}
