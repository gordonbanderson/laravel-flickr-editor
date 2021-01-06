<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flickr_sets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('flickr_id', 255)->unique();
            $table->index('flickr_id');
            $table->string('title');
            $table->text('description');

            $table->boolean('is_dirty')->default(false);
            $table->boolean('lock_geo')->default(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flickr_sets');
    }
}
