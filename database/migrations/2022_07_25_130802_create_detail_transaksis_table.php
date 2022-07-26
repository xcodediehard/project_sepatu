<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string("order_id")->index();
            $table->unsignedBigInteger("detail_barang_id")->index()->nullable();
            $table->integer("jumlah");
            $table->integer("biaya");
            $table->integer("diskon");
            $table->enum("status", [1, 0])->default(0);
            $table->timestamps();
        });

        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->foreign("order_id")->references("order_id")->on("transaksis")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign("detail_barang_id")->references("id")->on("detail_barangs")->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksis');
    }
}
