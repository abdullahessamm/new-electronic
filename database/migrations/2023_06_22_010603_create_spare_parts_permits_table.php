<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts_permits', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('user_id')->unsigned()->nullable();
            $table->string('permit_number', 60);
            $table->string('case_number', 60);
            $table->string('client_name', 60);
            $table->string('description');
            $table->foreign('user_id')->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('set null');
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
        Schema::dropIfExists('spare_parts_permits');
    }
};
