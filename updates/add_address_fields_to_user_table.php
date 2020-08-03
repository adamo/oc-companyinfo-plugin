<?php namespace Depcore\UserReview\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddAddressFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string( 'street',30 )->nullable(  );
            $table->string( 'number',10 )->nullable(  );
            $table->string( 'city',50 )->nullable(  );
            $table->string( 'post_code',10 )->nullable(  );
            $table->integer('country_id')->unsigned()->nullable()->index();
            $table->integer('state_id')->unsigned()->nullable()->index();
        });
    }

    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('country_id','street','post_code','city','number','state_id');
        });
    }
}
