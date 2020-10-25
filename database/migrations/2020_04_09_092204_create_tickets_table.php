<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('file', 255)->nullable();
            $table->string('rnd_code', 255);
            $table->enum('status', [0, 1])->default(0);// 0=>darhale barrasi,1=>pasokh dade shode
            $table->enum('type', [0, 1, 2, 3])->default(0); // Question or Task or ...admin -accounter
            $table->enum('advantage', [0, 1, 2])->default(0)->default('2'); // 0=> 'fori', 1=>'mohem', 2=>'addi'

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->text('message');
            $table->bigInteger('parent_id')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
