<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_detail_germe extends Model
{
    protected $fillable=['id','refResultatBacterie','refGerme','author'];
    protected $table = 'tlabo_detail_germe';
}
