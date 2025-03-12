<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvaleurnormale extends Model
{
    protected $fillable=['id','designation','refExamen','detailValeur','unite'];
    protected $table = 'tvaleurnormale';
}
