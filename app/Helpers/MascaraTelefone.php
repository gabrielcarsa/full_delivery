<?php

namespace App\Helpers;

class MascaraTelefone
{
    public static function formatPhoneNumber($telefone)
    {
        $cleaned = preg_replace('/[^0-9]/', '', $telefone);
        if (strlen($cleaned) == 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $cleaned);
        }
        return $telefone;
    }
}
