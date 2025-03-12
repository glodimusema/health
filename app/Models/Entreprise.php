<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = [
        'idProvince', 'ceo','nom','email',  'adresse','tel1',   'tel2',   'siteweb','facebook',   
        'twitter','linkedin',   'idnational', 'rccm',   'numImpot',   'logo',   'id_user_insert', 
        'id_user_update', 'id_user_delete', 'busnessName','codeBusness','idSecteur',  
        'contactNumCode', 'anneeFondation', 'numCaisseSocial','numInpp','idForme',
        'numPersonneJuridique','statut',
   ];
   protected $table = 'entreprise';

}
