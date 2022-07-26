<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeranjangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pelanggan_id")->index();
            $table->unsignedBigInteger("detail_barang_id")->index()->nullable();
            $table->integer("jumlah");
            $table->timestamps();
        });
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->foreign("pelanggan_id")->references("id")->on("pelanggans")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign("detail_barang_id")->references("id")->on("detail_barangs")->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keranjangs');
    }
}
