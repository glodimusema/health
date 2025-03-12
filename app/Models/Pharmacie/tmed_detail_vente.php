<?php

namespace App\Models\Pharmacie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmed_detail_vente extends Model
{
    protected $fillable=['id','refEnteteVente','refDetailMed','puVente','qteVente','author'];
    protected $table = 'tmed_detail_vente';
}
