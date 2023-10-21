<?php

namespace App\Jobs;

use App\Mail\InvitationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendMailTemplateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $employee;
    public $email_body;
    public $employeeRepository;
    /**
     * Create a new job instance.
     */
    public function __construct($employee, $email_body, $employeeRepository)
    {
        $this->employee = $employee;
        $this->email_body = $email_body;
        $this->employeeRepository = $employeeRepository;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $temperory_password = Str::random(12);
        $data = $this->email_body;
        // $data = Str::replace('[Employee Name]', $this->employee->name, $data);
        // $data = Str::replace('[Temporary Password]', $temperory_password, $data);
        $this->employeeRepository->updatePassword($this->employee->id,  Hash::make($temperory_password));
        // Mail::to($this->employee->email)->send(new InvitationEmail($this->employee->name, $temperory_password, $data));
    }
}
