<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_medicament extends Model
{
    protected $fillable=['id','nom_medicament','refcategoriemedicament','pu_medicament','forme','qtetot','stock_alerte','author'];
    protected $table = 'tconf_medicament';
}
