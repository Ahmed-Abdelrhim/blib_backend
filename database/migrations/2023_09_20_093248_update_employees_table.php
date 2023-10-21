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
        Schema::table('employees', function (Blueprint $table) {

            $table->unsignedBigInteger('company_id')->change();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->unsignedBigInteger('department_id')->nullable()->change();
            $table->foreign('department_id')->references('id')->on('departments');


            $table->unsignedBigInteger('reports_to_id')->nullable()->change();
            $table->foreign('reports_to_id')->references('id')->on('employees');


            $table->unsignedBigInteger('gender_id')->nullable()->change();
            $table->foreign('gender_id')->references('id')->on('cms');


            $table->unsignedBigInteger('military_status_id')->nullable()->change();
            $table->foreign('military_status_id')->references('id')->on('cms');


            $table->unsignedBigInteger('vacation_first_approval_id')->nullable()->change();
            $table->foreign('vacation_first_approval_id')->references('id')->on('employees');


            $table->unsignedBigInteger('vacation_second_approval_id')->nullable()->change();
            $table->foreign('vacation_second_approval_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['ceo_id']);
        });
    }
};
