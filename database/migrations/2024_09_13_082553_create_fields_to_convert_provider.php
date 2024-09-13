<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsToConvertProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('trong_tre_user')) {
            Schema::table('trong_tre_user', function (Blueprint $table) {                
                $table->date('convert')->nullable()->default(NULL);
            });
        }       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('trong_tre_user')) {
            Schema::table('trong_tre_user', function (Blueprint $table) {                
                $table->date('convert')->nullable()->default(NULL);
            });
        }  
    }
}
