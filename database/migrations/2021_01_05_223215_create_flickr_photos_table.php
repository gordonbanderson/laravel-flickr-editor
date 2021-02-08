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
        Schema::create('flickr_photos', function (Blueprint $table) {
            $table->id();
            $table->string('flickr_id', 255)->unique();
            $table->string('title');
            $table->text('description')->default('');
            $table->point('location')->nullable();

            $table->timestamp('taken_at')->nullable();
            $table->timestamp('flickr_last_updated')->nullable();
            $table->boolean('geo_is_public')->default(true);
            $table->boolean('lock_geo')->default(false);
            $table->boolean('is_dirty')->default(false);
            $table->boolean('is_public')->default(false);
            $table->integer('orientation')->nullable()->default(null);
            $table->integer('rotation')->default(0);
            $table->integer('accuracy')->default(0);
            $table->string('woe_id')->nullable();
            $table->string('flickr_place_id')->nullable();

            $table->float('aperture')->nullable();
            $table->string('shutter_speed')->nullable();
            $table->integer('focal_length_35mm')->nullable();
            $table->integer('iso')->nullable();

            // ---- small ----
            $table->string('small_url');
            $table->integer('small_height');
            $table->integer('small_width');

            $table->string('small_url_150')->nullable();
            $table->integer('small_height_150')->nullable();
            $table->integer('small_width_150')->nullable();

            $table->string('small_url_320')->nullable();
            $table->integer('small_height_320')->nullable();
            $table->integer('small_width_320')->nullable();



            // ---- medium ----
            $table->string('medium_url');
            $table->integer('medium_height');
            $table->integer('medium_width');

            $table->string('medium_url_640')->nullable();
            $table->integer('medium_height_640')->nullable();
            $table->integer('medium_width_640')->nullable();

            $table->string('medium_url_800')->nullable();
            $table->integer('medium_height_800')->nullable();
            $table->integer('medium_width_800')->nullable();


            // ---- square ----
            $table->string('square_url');
            $table->integer('square_height');
            $table->integer('square_width');

            $table->string('square_url_150')->nullable();
            $table->integer('square_height_150')->nullable();
            $table->integer('square_width_150')->nullable();


            // ---- large ----
            $table->string('large_url')->nullable();
            $table->integer('large_height')->nullable();
            $table->integer('large_width')->nullable();

            $table->string('large_url_1600')->nullable();
            $table->integer('large_height_1600')->nullable();
            $table->integer('large_width_1600')->nullable();

            $table->string('large_url_2048')->nullable();
            $table->integer('large_height_2048')->nullable();
            $table->integer('large_width_2048')->nullable();

            // ---- thumbnail ----
            $table->string('thumbnail_url');
            $table->integer('thumbnail_height');
            $table->integer('thumbnail_width');

            // ---- original ----
            $table->string('original_url');
            $table->integer('original_height');
            $table->integer('original_width');


            // @todo is this required?
            $table->integer('time_shift_hours')->default(0);

            $table->boolean('exif_imported')->default(false);
            $table->float('digital_zoom_ratio')->default(1);

            // @todo fix nullable
            $table->timestamp('upload_unix_time_stamp')->nullable();

            $table->string('perceptive_hash')->nullable();

            $table->float('aspect_ratio')->nullable();

            $table->string('image_unique_id')->nullable();
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
        Schema::dropIfExists('flickr_photos');
    }
}
