<?php

namespace App\Models\Dyalise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdyal_detail_ophtamologie extends Model
{
    protected $fillable=['id','refDetailConst','dateOphta','visionDeLoin_ob','visionDePres_ob','visionDeLoin_oG','visionDePres_OG',
    'observation','paut','branche','entredragoire', 'auther'];
    protected $table = 'tdyal_detail_ophtamologie';
    
}



