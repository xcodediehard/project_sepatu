<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMereksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mereks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->index()->nullable();
            $table->string("merek_name")->unique();
            $table->timestamps();
        });

        Schema::table('mereks', function (Blueprint $table) {
            $table->foreign('user_id')->references("id")->on("users")->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mereks');
    }
}
