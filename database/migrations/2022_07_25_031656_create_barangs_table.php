<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("merek_id")->index();
            $table->string("barang_name")->unique();
            $table->integer("barang_harga");
            $table->text("barang_keterangan");
            $table->string("barang_gambar");
            $table->timestamps();
        });

        Schema::table('barangs', function (Blueprint $table) {
            $table->foreign('merek_id')->references("id")->on("mereks")->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
