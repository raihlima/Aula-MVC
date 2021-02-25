<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscricaoCampeonato extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'idJogador',
        'idCampeonato',
        'nomeTime',
        'nomeJogadores',
    ];

    public function retornaCampeonato()
    {
        return Campeonato::find($this->idCampeonato);
    }
}
