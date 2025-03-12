<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_enteteevaluation extends Model
{
    protected $fillable=[
    'id','refEnteteOpe','medecin','anesthesiste','infirmier','dateEvaluation','author'];
    protected $table = 'tope_enteteevaluation';

            
}
