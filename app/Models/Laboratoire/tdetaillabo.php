<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdetaillabo extends Model
{
    protected $fillable=['id','refEnteteLabo','refValeur','libelle','observation','author','natureechantillon','methode','commentaire'];
    protected $table = 'tdetaillabo';
}
