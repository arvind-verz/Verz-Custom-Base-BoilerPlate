<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeTrainingContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_training_contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name_of_law_practice')->nullable();
			$table->text('name_of_supervising_solicitor')->nullable();
			$table->string('area_practiced_offered')->nullable();
			$table->string('honorarium')->nullable();
			$table->integer('no_of_vacancies')->nullable();
			$table->timestamp('date_of_commencement')->nullable();
			$table->string('contact_person')->nullable();
			$table->string('email')->nullable();
			$table->string('contact_no')->nullable();
			$table->text('general_information')->nullable();
			$table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('practice_training_contracts');
    }
}
