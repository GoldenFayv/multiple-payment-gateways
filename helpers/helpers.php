<?php
require_once __DIR__ . '/response.php';


function generateCode(int $length = 6): string
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $code;
}
