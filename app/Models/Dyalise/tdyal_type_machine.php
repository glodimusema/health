<?php

namespace App\Models\Dyalise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdyal_type_machine extends Model
{
    protected $fillable=['id','nomTypeMachine','description'];
    protected $table = 'tdyal_type_machine';
    
}
