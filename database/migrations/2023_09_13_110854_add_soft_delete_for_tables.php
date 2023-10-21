<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function(Blueprint $table)
        {
            $table->softDeletes();
        });


        Schema::table('departments', function(Blueprint $table)
        {
            $table->softDeletes();
        });


        Schema::table('companies', function(Blueprint $table)
        {
            $table->softDeletes();
        });



        Schema::table('plans', function(Blueprint $table)
        {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function(Blueprint $table)
        {
            $table->dropSoftDeletes();
        });


        Schema::table('departments', function(Blueprint $table)
        {
            $table->dropSoftDeletes();
        });


        Schema::table('companies', function(Blueprint $table)
        {
            $table->dropSoftDeletes();
        });


        Schema::table('plans', function(Blueprint $table)
        {
            $table->dropSoftDeletes();
        });
    }
};
