<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanKlienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan_klien', function (Blueprint $table) {
            $table->bigIncrements('tagihan_id');
            $table->string('tagihan_no',15);
            $table->string('tagihan_periode');
            $table->integer('tagihan_ppn')->nullable();
            $table->integer('tagihan_total')->nullable();
            $table->integer('materai')->nullable();
            $table->string('status_bayar',10);
            // $table->string('pinet_id');
            $table->integer('k_id')->unsigned();
            $table->index(['pinet_id','k_id']);
            // $table->foreign('pinet_id')->references('pinet_id')->on('paket_internet')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('k_id')->references('k_id')->on('klien')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagihan_klien');
    }
}
