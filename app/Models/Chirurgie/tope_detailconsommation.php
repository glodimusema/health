<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_detailconsommation extends Model
{
    protected $fillable=['id','refEnteteConso','refmedicament','puCons','qteCons','author'
    ];
    protected $table = 'tope_detailconsommation';

            
}
