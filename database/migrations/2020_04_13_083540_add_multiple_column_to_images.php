<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnToImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->default(0)->after('id');;
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('new_sources')->after('sources');
            $table->string('slider_sources')->after('new_sources');
            $table->string('gallery_sources')->after('slider_sources');
            $table->json('exif')->after('User_id');
            $table->string('p_hash')->unique()->after('exif');
            $table->string('f_hash')->unique()->after('p_hash');
            $table->string('s_hash')->unique()->after('f_hash');
            $table->enum('status',[0,1])->default('1')->after('s_hash');
            $table->softDeletes()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('status', 'exif', 'hash','deleted_at');
        });
    }
}
