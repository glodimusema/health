<?php

namespace App\Models\Dyalise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdyal_vaccination_dyalise extends Model
{
    protected $fillable=['id','refEnteteDyalise','refTypeMachine',
    'refVaccinDyalise','dateVaccin','dose','dosageLitre','observation','infirmier','auther'];
    protected $table = 'tdyal_vaccination_dyalise';
    
}
