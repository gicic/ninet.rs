<?php


namespace App\Services\Customers;


class Customers
{
    public static function verifyEmail($encrypted)
    {
        try {
            return \App\Services\CoreAPI\Facades\CoreAPI::makeRequest('post', '/customer/verify-email', [], [
                'encrypted' => $encrypted,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error', [ 'exception' => $e]);
            return false;
        }
    }
}