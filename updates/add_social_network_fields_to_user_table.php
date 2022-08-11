<?php namespace Depcore\CompanyInfo\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddPhoneToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string( 'instagram',120 )->nullable(  );
            $table->string( 'linkedin',140 )->nullable(  );
            $table->string( 'youtube',150 )->nullable(  );
        });
    }

    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('instagram', 'youtube', 'linkedin');
        });
    }
}