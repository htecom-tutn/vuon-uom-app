<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexForTTUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->table('trong_tre_user', function (Blueprint $table) {
            $table->index(['username']);
            $table->index(['dien_thoai']);
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql1')->table('trong_tre_user', function (Blueprint $table) {
            $table->index(['username']);
            $table->index(['dien_thoai']);
        });   
    }
}
