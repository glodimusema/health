<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_categorie_echantillon extends Model
{
     //tlabo_examencolore : id,nom_examencolore,author
    protected $fillable=['id','nom_categorieechantillon','author'];
    protected $table = 'tlabo_categorie_echantillon';
}
