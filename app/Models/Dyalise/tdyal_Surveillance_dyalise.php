<?php

namespace App\Models\Dyalise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdyal_Surveillance_dyalise extends Model
{
    protected $fillable=['id','refEnteteDyalise','refTypeMachine','Bpo','balus','dialiseur','poidsSec','poidsApres',
    'poidsAvant','fer','infusion','dialysate','claurenceUree', 'volumeSang','kttinal','instruction','author'];
    protected $table = 'tdyal_surveillance_dyalise';
    
}

//