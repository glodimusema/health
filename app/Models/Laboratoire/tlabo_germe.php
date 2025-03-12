<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_germe extends Model
{
    protected $fillable=['id','nom_germe','author'];
    protected $table = 'tlabo_germe';
}
