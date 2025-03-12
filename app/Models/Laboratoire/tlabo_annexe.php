<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_annexe extends Model
{

    protected $fillable=['id','refEnteteLabo','pdfLabo','descriptionImage','author'];
    protected $table = 'tlabo_annexe';

}