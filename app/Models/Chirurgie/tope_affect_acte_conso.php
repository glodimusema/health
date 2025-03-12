<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_affect_acte_conso extends Model
{
    protected $fillable=[
    'id','refEnteteConso','refActeOpratoire','author'];
    protected $table = 'tope_affect_acte_conso';

            
}
