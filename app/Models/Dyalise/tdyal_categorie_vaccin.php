<?php

namespace App\Models\Dyalise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdyal_categorie_vaccin extends Model
{
    protected $fillable=['id','nomCategorieVac'];
    protected $table = 'tdyal_categorie_vaccin';
    
}
