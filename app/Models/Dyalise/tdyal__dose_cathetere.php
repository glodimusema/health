<?php

namespace App\Models\Dyalise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdyal__dose_cathetere extends Model
{
    protected $fillable=['id','refEnteteDyalise','refTypeMachine','indication',
    'dateDose','shifts','KT','CM_marque','Dimension','siteactuel','lieu','autres','operateur_Dr',
    'assistant','infirmier','descriptionOperation','PA_avant','PA_apres','pauls_avant','pauls_apres',
    "FR_avant","FR_Apres",'saO2_avant','saO2_apres','to_avant','to_apres',"Plaquette_avant", "Plaquette_apres",'observation','instruction'
     ];
    protected $table = 'tdyal__dose_cathetere';
    
}

