<?php

namespace App\Models\Pharmacie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmed_detail_entree extends Model
{
    protected $fillable=['id','refEnteteEntree','refmedicament','dateExpiration','numeroLot','puEntree','qteEntree','author'];
    protected $table = 'tmed_detail_entree';
}
