<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_actesposemedecin extends Model
{
    protected $fillable=['id','refDetailCons','refActemedecin','descriptionacte','author'];
    protected $table = 'tfin_actesposemedecin';
}
