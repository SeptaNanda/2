<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('mahasiswa',function(Blueprint $table){
            $table->string("nim")->primary();
            $table->string("nama")->nullable(false);
            $table->string("kelas")->nullable(false);
            $table->string("jurusan")->nullable(false);
            $table->string("nomor_handphone")->nullable(false);
            $table->string("email")->unique();
            $table->date("tgl_lahir")->nullable(false);
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
        //
        Schema::dropIfExists('mahasiswa');
    }
}
