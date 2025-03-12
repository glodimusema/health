<?php

namespace App\Models\Pharmacie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfournisseur extends Model
{
    protected $fillable=['id','noms','contact','mail','adresse','author'];
    protected $table = 'tfournisseur';
}
