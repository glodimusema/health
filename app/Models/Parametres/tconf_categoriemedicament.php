<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_categoriemedicament extends Model
{
    protected $fillable=['id','nom_categoriemedicament'];
    protected $table = 'tconf_categoriemedicament';
}
