<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_categorie_societe extends Model
{
    protected $fillable=['id','name_categorie_societe'];
    protected $table = 'tfin_categorie_societe';
}
