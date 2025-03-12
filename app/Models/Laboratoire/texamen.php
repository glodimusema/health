<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class texamen extends Model
{
    protected $fillable=['id','designation','refCatexamen','PrixExam','refTube'];
    protected $table = 'texamen';
}
