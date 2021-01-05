<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlickrPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flickrphotos', function (Blueprint $table) {
            $table->id();
            $table->string('flickrid', 255)->unique();
            $table->index('flickrid');
            $table->string('title');
            $table->text('description');
            $table->point('location')->nullable();
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
        Schema::table('flickrphotos', function (Blueprint $table) {
            //
        });
    }
}
