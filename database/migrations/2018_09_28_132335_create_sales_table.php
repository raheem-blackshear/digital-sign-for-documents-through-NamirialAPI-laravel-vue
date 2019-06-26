<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('age');
            $table->integer('packageType')->nullable();;
            $table->integer('price');
            $table->integer('seller_id');

            $table->string('contractorType');
            $table->string('contractorFirstName');
            $table->string('contractorLastName');
            $table->string('contractorAddress')->nullable();
            $table->string('contractorTaxCode')->nullable();
            $table->string('contractorBirthday')->nullable();
            $table->string('contractorBirthPlace')->nullable();
            $table->string('contractorEmail')->nullable();
            $table->string('contractorTelephone')->nullable();
            $table->string('insuredType')->nullable();;
            $table->string('insuredFirstName')->nullable();;
            $table->string('insuredLastName')->nullable();;
            $table->string('insuredAddress')->nullable();
            $table->string('insuredTaxCode')->nullable();
            $table->string('insuredBirthday')->nullable();
            $table->string('insuredBirthPlace')->nullable();
            $table->string('insuredEmail')->nullable();
            $table->string('insuredTelephone')->nullable();
            $table->string('deathBenType')->nullable();;
            $table->string('deathBenFirstName')->nullable();;
            $table->string('deathBenLastName')->nullable();;
            $table->string('deathBenAddress')->nullable();
            $table->string('deathBenTaxCode')->nullable();
            $table->string('deathBenBirthday')->nullable();
            $table->string('deathBenBirthPlace')->nullable();
            $table->string('deathBenEmail')->nullable();
            $table->string('deathBenTelephone')->nullable();
            $table->string('receiveEmail')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
