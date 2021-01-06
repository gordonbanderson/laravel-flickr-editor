<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlickrPhotoFlickrSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flickr_photo_flickr_set', function (Blueprint $table) {
            $table->id();
            $table->integer('flickr_photo_id')->unsigned();
            $table->integer('flickr_set_id')->unsigned();
            $table->foreign('flickr_photo_id')->references('id')->on('flickr_photos')->onDelete('cascade');
            $table->foreign('flickr_set_id')->references('id')->on('flickr_sets')->onDelete('cascade');
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
        Schema::dropIfExists('flickr_photo_flickr_set');
    }
}
