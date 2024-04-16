<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplyForTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_for', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id');
            $table->foreignId('user_id');
            $table->string('cv');
            $table->enum('status', [0, 1,2])->default('0'); // 0 for pending 1 for accepted 2 for rejected
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
        Schema::dropIfExists('apply_for');
    }
}
