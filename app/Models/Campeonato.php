<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campeonato extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'dataLimiteInscricao',
        'dataInicioCampeonato',
        'jogo',
        ];

    protected $dates = [
            'dataLimiteInscricao',
            'dataInicioCampeonato',
            'created_at',
            'updated_at',
            ];

    const GAME_SELECT = [
        'ragnarok' => 'Ragnarok',
        'cs_go' => 'CS:GO',
        'truco' => 'Truco Online',
        'gunbound' => 'Gunbound',
    ];
}
