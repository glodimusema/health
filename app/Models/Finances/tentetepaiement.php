<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tentetepaiement extends Model
{
    protected $fillable=['id','refMouvement','dateentetepaie','author'];
    protected $table = 'tentetepaiement';
}
