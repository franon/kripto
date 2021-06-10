<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketKlienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_klien', function (Blueprint $table) {
            $table->string('pk_id');
            $table->string('pk_no');
            $table->integer('pk_harga');
            // $table->string('k_id');
            $table->integer('k_id')->unsigned();
            $table->string('pinet_id');
            $table->primary('pk_id');
            $table->index(['k_id','pinet_id']);
            $table->foreign('k_id')->references('k_id')->on('klien')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pinet_id')->references('pinet_id')->on('paket_internet')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_klien');
    }
}
