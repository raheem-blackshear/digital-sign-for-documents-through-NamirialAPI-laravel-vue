<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnvelopeIdToSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function($table) {
            $table->string('envelope_id')->default("");
            $table->string('envelope_id_two')->default("");
            $table->string('envelope_id_three')->default("");
            $table->text('personalInfo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function($table) {
            $table->string('envelope_id');
        });
    }
}
