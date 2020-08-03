<?php namespace Depcore\CompanyInfo\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBusinessesTable extends Migration
{
    public function up()
    {
        Schema::create('depcore_companyinfo_businesses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('user_id');
            $table->string('company_name');
            $table->string('identification_number');
            $table->string('street_name',30)->nullable();
            $table->string('street_number',10)->nullable();
            $table->string('post_code',30)->nullable();
            $table->string('city',50)->nullable();
            $table->integer('country_id')->unsigned()->nullable()->index();
            $table->integer('state_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('depcore_companyinfo_businesses');
    }
}
