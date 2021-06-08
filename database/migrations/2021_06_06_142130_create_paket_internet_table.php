<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketInternetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_internet', function (Blueprint $table) {
            $table->string('pinet_id');
            $table->string('pinet_tipe');
            $table->integer('pinet_harga');
            $table->primary('pinet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_internet');
    }
}
