<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('active', [0, 1])->default(0);
            $table->enum('type', [1,2,3])->default(1); // user or admin or ...
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('name');
            $table->string('f_name')->nullable();
            $table->string('user_name')->unique()->nullable();
            $table->tinyInteger('gender')->nullable(); //1 man & 2 woman
            $table->string('photo', 200)->nullable();//
            $table->string('instagram', 200)->nullable();//
            $table->string('twitter', 200)->nullable();//
            $table->string('facebook', 200)->nullable();//
            $table->text('portfolio')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_code')->nullable();
            $table->integer('is_verified')->default(0);
            $table->string('provider');
            $table->string('provider_id');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
