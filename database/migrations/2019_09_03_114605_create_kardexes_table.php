<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardexes', function (Blueprint $table) {
        $table->unsignedInteger('id_student');
        $table->unsignedInteger('id_subject');
        $table->integer('opportunity')->default(1);
        $table->integer('semester')->default(1);
        $table->float('grade',3,2)->default(0.0);
        $table->float('average',3,2)->default(0.0);
        $table->timestamps();
        $table->primary(['id_student', 'id_subject']);
        $table->foreign('id_student')->references('id')->on('users');
        $table->foreign('id_subject')->references('id')->on('subjects');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardexes');
    }
}
