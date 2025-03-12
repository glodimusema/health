<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_detail_bilan_hydrique extends Model
{
    protected $fillable=['id','refBilan','heure','perfusion','peros','qte','drains',
    'sng','duirise','selles','author'];
    protected $table = 'thospi_detail_bilan_hydrique';
}



