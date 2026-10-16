<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtatClasse extends Model
{
    protected $table ='classe_etats';
    public $incrementing =false;
    public $timestamps = false;
    protected $fillable = [
            'id',
            'prochain_id',
            'initialisee',
            'taille_max',
            'signature_source',
            'cree_le',
            'maximum_mixtes',
            'score'
    ];


}
