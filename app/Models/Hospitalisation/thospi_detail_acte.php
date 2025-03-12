<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_detail_acte extends Model
{
    //
    protected $fillable=[
    'id','refTraitem','refActeMedicale','description','fait08h','qte08h',
    'fait09h','qte09h','fait10h','qte10h','fait11h','qte11h','fait12h','qte12h','fait13h','qte13h'
    ,'fait14h','qte14h','fait15h','qte15h','fait16h','qte16h','fait17h','qte17h','fait18h','qte18h'
    ,'fait19h','qte19h','fait20h','qte20h','fait21h','qte21h','fait22h','qte22h','fait23h','qte23h'
    ,'fait24h','qte24h','fait01h','qte01h','fait02h','qte02h','fait03h','qte03h','fait04h','qte04h'
    ,'fait05h','qte05h','fait06h','qte06h','fait07h','qte07h','observation','author'];
    protected $table = 'thospi_detail_acte';
}


