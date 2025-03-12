<?php

namespace App\Models\Dyalise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdyal_detail_surveillance_dyal extends Model
{
    protected $fillable=['id','refSurvDyalise','heures','ta_dyal','Bp','Map','HR',
    'poids','temperature','PA','PV', 'TMP','QB','QD','TempsDialiat','UFVol', 'Observation','auther'];
    protected $table = 'tdyal_detail_surveillance_dyal';
    
}


