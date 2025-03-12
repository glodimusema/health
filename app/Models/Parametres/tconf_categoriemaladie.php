<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_categoriemaladie extends Model
{
    protected $fillable=['id','nom_categoriemaladie'];
    protected $table = 'tconf_categoriemaladie';
}
