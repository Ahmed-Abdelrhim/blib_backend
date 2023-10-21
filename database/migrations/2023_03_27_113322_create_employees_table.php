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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('title')->nullable();
                $table->date('joined_at')->nullable();  
                $table->string('password')->nullable();
                $table->string('phone',15)->nullable();
                $table->string('country_code',5)->nullable();
                $table->date('date_of_birth')->nullable();
                $table->integer('department_id')->nullable();
                $table->integer('reports_to_id')->nullable();
                $table->string('temp_reports_to_email')->nullable();
                $table->integer('role_id')->nullable();
                $table->string('image')->nullable();
                $table->string('banner')->nullable();
                $table->text('description')->nullable();
                $table->string('bio')->nullable();
                $table->integer('gender_id')->nullable();
                $table->integer('military_status_id')->nullable();
                $table->string('country')->nullable();
                $table->string('address')->nullable();
                $table->float('salary')->nullable();
                $table->string('currency')->default('EGP');
                $table->enum('work_hours',array('Full Time','Part Time','Fully Remotely','Part Time Remotely','Casual','Fixed Term Contract','Apprenticeship','Internship'))->default('Full Time');
                $table->boolean('is_important')->default(0);
                $table->boolean('is_personal_information_complete')->default(0);
                $table->boolean('is_work_information_complete')->default(0);
                $table->boolean('is_vacations_complete')->default(0);
                $table->boolean('is_first_time')->default(1);
                $table->boolean('is_complete')->default(0);
                $table->date('vacation_activate_at')->nullable();
                $table->date('vacation_expire_carry_at')->nullable();
                $table->integer('vacation_first_approval_id')->nullable();
                $table->integer('vacation_second_approval_id')->nullable();
                $table->integer('vacation_annual_days')->default(0);
                $table->integer('vacation_carry_days')->default(0);
                $table->timestamps();
                $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
