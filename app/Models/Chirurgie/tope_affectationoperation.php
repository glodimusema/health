<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_affectationoperation extends Model
{
    protected $fillable=['id','refDetailOpe','refActeOpratoire','descriptionActe','author'];
    protected $table = 'tope_affectationoperation';


            
}
