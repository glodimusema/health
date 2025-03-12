<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_detailoperation extends Model
{
    protected $fillable=['id','refEnteteOpe','datedetailOpe','diagnosticPresOpe','anesthesiste','chirurgien',
    'assistant','infirmiercirculant','diagnosticPostOpe','perteSanguine','Complication','instructionPrescription',
    'author'];
    protected $table = 'tope_detailoperation';
}
