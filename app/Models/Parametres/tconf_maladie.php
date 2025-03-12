<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_maladie extends Model
{
    protected $fillable=['id','nom_maladie','refcategoriemaladie','author'];
    protected $table = 'tconf_maladie';
}
