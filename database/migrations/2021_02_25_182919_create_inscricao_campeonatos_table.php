<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscricaoCampeonatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscricao_campeonatos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idJogador');
            $table->foreign('idJogador')->references('id')->on('users');
            $table->unsignedBigInteger('idCampeonato');
            $table->foreign('idCampeonato')->references('id')->on('campeonatos');
            $table->text('nomeTime');
            $table->text('nomeJogadores');
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscricao_campeonatos');
    }
}
