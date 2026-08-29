<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class Operations
{

    public static function encryptId($id)
    {
        return Crypt::encrypt($id);
    }


    public function decryptId($encryptedId)
    {
        try {
            return Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            return null;
        }
    }
}