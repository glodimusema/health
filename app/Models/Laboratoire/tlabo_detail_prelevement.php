<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_detail_prelevement extends Model
{
    protected $fillable=['id','refEntetePrelevement','refEchantillon','author'];
    protected $table = 'tlabo_detail_prelevement';
}
