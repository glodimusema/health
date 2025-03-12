<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdetailsouscription extends Model
{
    protected $fillable=['id','refEnteteVente','refProduit','refSouscription','statut','author'];
    protected $table = 'tdetailsouscription';
}
