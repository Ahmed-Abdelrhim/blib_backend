<?php

namespace App\Services;

use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Services\Interfaces\MailServiceInterface;
use Exception;
use SendGrid\Mail\Personalization;
use SendGrid\Mail\To;


class MailService implements MailServiceInterface
{

    private $employeeRepositoryInterface;

    public function __construct(EmployeeRepositoryInterface $employeeRepositoryInterface)
    {
        $this->employeeRepositoryInterface = $employeeRepositoryInterface;
    }

    public function sendMail(string $title, string $to, array $listOfMails, string $html)
    {
        // $email = new \SendGrid\Mail\Mail();
        
        // $email->setFrom("blip@social-nuts.com", "Blip Application"); 
        // $email->setSubject($title);
        // $email->addTo($to); // to

        // foreach ($listOfMails as $value) {
        //     $personalization = new Personalization();
        //     $personalization->addTo(new To($value));
        //     $email->addPersonalization($personalization);
        // }

        // $email->addContent("text/html", $html);
        // $sendgrid = new \SendGrid('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');
        // try {
        //     $response = $sendgrid->send($email);
        //     return $response;
        // } catch (Exception $e) {
        //     return false;
        // }
    }
}
