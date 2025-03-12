<?php

namespace App\Models\Rendezvous;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tagendamedecin extends Model
{
    protected $fillable=['id','refUser','dateRDV','noms','contact','lieu','motif','statut','author'];
    protected $table = 'tagendamedecin';
}
