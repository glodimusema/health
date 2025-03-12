<?php

namespace App\Models\Reanimation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trea_surveillance_rea extends Model
{       
    protected $fillable=
    [
    'id',
    'refEnteteRea',
    'dateTraiteRea',
    'pauls',
    'heureTraite',
    'PAS',
    'diagosticRea',
    'PAD',
    'temperatureTrait',
    'ta',
    'pam',
    'spo2',
    'scareGlosgow',
    'mode_vendilatoire',
    'volmin',
    'fi02',
    'frequence',
    'peep',
    'Fr_traitRea',
    'tempsInstall',
    'tempsPause',
    'oxygeneTraitRea',
    'contrepressionMax',
    'oxygene',
    'pressionCrate',
    'auther'
    ];
    protected $table = 'trea_surveillance_rea';
}
