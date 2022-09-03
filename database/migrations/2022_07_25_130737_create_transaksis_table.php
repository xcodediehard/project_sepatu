<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pelanggan_id")->index()->nullable();
            $table->string("order_id")->index()->nullable();
            $table->text("alamat");
            $table->integer("biaya");
            $table->enum("status", [1, 2, 3, 4]);
            $table->timestamps();
        });

        Schema::table('transaksis', function (Blueprint $table) {
            $table->foreign("pelanggan_id")->references("id")->on("pelanggans")->cascadeOnUpdate()->nullOnDelete();
            $table->foreign("order_id")->references("order_id")->on("midtrans_data")->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
