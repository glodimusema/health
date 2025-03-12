<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tentetesouscription extends Model
{
    protected $fillable=['id','refClient','dateSous','dateExecution','Executant','author'];
    protected $table = 'tentetesouscription';
}
