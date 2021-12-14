<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regulations', function (Blueprint $table) {
            $table->id('guid');
            $table->string('link')->comment('Ссылка на проект');
            $table->string('author')->comment('Email автора');
            $table->string('title', 2000)->comment('Полное название проекта');
            $table->string('project_id')->comment('ID проекта');
            $table->date('project_created')->comment('Дата создания');
            $table->string('project_developer')->comment('Разработчик');
            $table->string('procedure')->comment('Процедура');
            $table->string('kind')->comment('Вид');
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
        Schema::dropIfExists('regulations');
    }
}
