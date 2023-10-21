<?php
namespace App\Services\Interfaces;

interface MailServiceInterface
{
   public function sendMail(string $title, string $to, array $listOfMails, string $html);
}