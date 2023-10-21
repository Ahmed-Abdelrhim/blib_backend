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
        Schema::table('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->change();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });


        Schema::table('cms', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->change();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });


        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->change();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });



        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('industry_id')->change();
            $table->foreign('industry_id')->references('id')->on('industries');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });


        Schema::table('cms', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });


        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });


        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['industry_id']);
            $table->dropForeign(['plan_id']);
        });

    }
};
