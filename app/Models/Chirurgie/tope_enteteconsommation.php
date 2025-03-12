<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_enteteconsommation extends Model
{
    protected $fillable=[
    'id','refEnteteOpe','refIntervention','refServiceHopital','refLit','dateIntervension','infirmier','chirurgien',
    'anesthesiste','diagnosticOpe','priseenCharge','author'];
    protected $table = 'tope_enteteconsommation';

                
}
