<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tentetelabo extends Model
{
    protected $fillable=['id','refEntetePrelevement','refExamen','dateLabo','statutentetelabo','serviceProvenance','author'];
    protected $table = 'tentetelabo';
}
