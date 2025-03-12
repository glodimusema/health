<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tentetelabo_ext extends Model
{
    protected $fillable=['id','refMouvement','refExamen','dateLabo','author','nommedecin','nomcentremedical',
     'adressecentre','telephonemedecin', 'mailmedecin', 'nompreleveur', 'dateprelevement','statutentetelaboext','serviceProvenance'];
    protected $table = 'tentetelabo_ext';
}
