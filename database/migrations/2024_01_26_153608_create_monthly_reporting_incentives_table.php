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
        Schema::create('monthly_reporting_incentives', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('by')->nullable();
            $table->dateTime('date');
            $table->string('case_number', 60);
            $table->string('client_name', 60);
            $table->string('warranty_status', 100);
            $table->text('comment')->nullable();
            $table->float('collection_fees')->default(0.00);
            $table->string('sap_number', 100);
            $table->boolean('damaged_position')->default(false);

            $table->foreign('by')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_reporting_incentives');
    }
};
