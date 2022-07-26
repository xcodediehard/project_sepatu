<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("barang_id")->index();
            $table->string("stok");
            $table->integer("size");
            $table->timestamps();
        });

        Schema::table('detail_barangs', function (Blueprint $table) {
            $table->foreign('barang_id')->references("id")->on("barangs")->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_barangs');
    }
}
