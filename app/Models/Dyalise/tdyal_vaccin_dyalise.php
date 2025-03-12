<?php

namespace App\Models\Dyalise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdyal_vaccin_dyalise extends Model
{
    protected $fillable=['id','refcategorieVac','nomVaccinDyal','auther'];
    protected $table = 'tdyal_vaccin_dyalise';
    
}