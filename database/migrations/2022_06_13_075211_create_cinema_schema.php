<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
    # Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories
     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {

        Schema::create('casts', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->string('position');
            $table->json('tags');
            $table->date('dob');
            $table->longText('bio');
            $table->timestamps();
        });

        Schema::create('movie_categories', function($table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('locations', function($table) {
            $table->increments('id');
            $table->string('name'); // United States
            $table->string('slug'); // united_states
            $table->string('short_name'); // US
            $table->timestamps();
        });

        Schema::create('movie_types', function($table) {
            $table->increments('id');
            $table->string('name'); // comedy, drama, family
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('seats', function($table) {
            $table->increments('id');
            $table->string('position');
            $table->string('type');
            $table->string('description')->nullabe();
            $table->timestamps();
        });

        Schema::create('seat_types', function($table) {
            $table->increments('id');
            $table->string('type');
            $table->string('discount');
            $table->integer('seat')->unsigned();
            $table->foreign('seat')->references('id')->on('seats')->onDelete('cascade');
            $table->timestamps();
        });


        Schema::create('movies', function($table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('description');
            $table->longText('about');
            $table->string('reactions');
            $table->string('image');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->dateTime('release_date');
            $table->boolean('is_promoted')->default(false);
            $table->boolean('is_fully_booked')->default(false);
            $table->float('price', 8, 2);
            $table->string('total_seat')->nullable();
            $table->integer('cast_id')->unsigned();
            $table->foreign('cast_id')->references('id')->on('casts')->onDelete('cascade');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('movie_categories')->onDelete('cascade');
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('movie_type')->unsigned();
            $table->foreign('movie_type')->references('id')->on('movie_types')->onDelete('cascade');
            $table->integer('seat_type')->unsigned();
            $table->foreign('seat_type')->references('id')->on('seat_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('bookings', function($table) {
            $table->increments('id');
            $table->dateTime('time');
            $table->string('number_of_seats');
            $table->integer('movie')->unsigned();
            $table->foreign('movie')->references('id')->on('movies')->onDelete('cascade');
            $table->integer('seat')->unsigned();
            $table->foreign('seat')->references('id')->on('seats')->onDelete('cascade');
            $table->string('description')->nullabe();
            $table->timestamps();
        });

        // throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
