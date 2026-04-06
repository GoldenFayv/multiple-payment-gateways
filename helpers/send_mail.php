<?php

use App\Mail\SharedMail;
use Illuminate\Support\Facades\Mail;

function sendMail(string $email, string $subject, string $view, array $data = [], array $attachment = [])
{
    function sendMail(string $email, string $subject, string $view, array $data = [], array $attachment = [])
    {
        try {
            // Queue the email instead of sending it immediately
            Mail::to($email)->queue(new SharedMail($subject, $view, $data, $attachment));
        } catch (\Throwable $th) {
            logger()->error("Error while sending mail", [$th]);
        }
    }
}
