<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_taux extends Model
{
    protected $fillable=['id','montant_taux'];
    protected $table = 'tfin_taux';
}
