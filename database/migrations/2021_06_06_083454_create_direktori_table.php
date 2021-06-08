<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirektoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direktori', function (Blueprint $table) {
            $table->string('dir_id');
            $table->string('p_id');
            // $table->string('file_id');
            $table->string('dir_nama');
            $table->string('dir_jalur');
            $table->string('dir_didalam')->nullable();
            $table->string('pembuat')->nullable();
            $table->date('tanggal_buat')->nullable();
            $table->primary('dir_id');
            $table->foreign('p_id')->references('p_id')->on('pengguna')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('file_id')->references('file_id')->on('file')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direktori');
    }
}
