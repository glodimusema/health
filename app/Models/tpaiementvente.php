<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tpaiementvente extends Model
{
    protected $fillable=['id','refEnteteVente','montant','datePaie','libelle','author'];
    protected $table = 'tpaiementvente';
}
