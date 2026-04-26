<?php

namespace App\Actions;

use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;

class SendMail
{
    public function handle(string $email, string $subject, string $view, array $data = [], array $attachment = [])
    {
        try {
            // Queue the email instead of sending it immediately
            Mail::to($email)->send(new UserMail($subject, $view, $data, $attachment));
        } catch (\Throwable $th) {
            logger()->error("Error occurred while sending mail", [$th]);
        }
    }
}
