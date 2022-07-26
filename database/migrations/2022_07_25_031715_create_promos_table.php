<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("barang_id")->index();
            $table->text("promo_nama");
            $table->string("promo_code");
            $table->string("promo_harga");
            $table->timestamps();
        });
        Schema::table('promos', function (Blueprint $table) {
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
        Schema::dropIfExists('promos');
    }
}
