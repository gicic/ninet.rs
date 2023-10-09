<?php


namespace App\Services\Orders;


class Orders
{
    public static function create($request)
    {
        try {
            return \App\Services\CoreAPI\Facades\CoreAPI::makeRequest('post', '/orders/create-medianis', [], [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'is_legal_entity' => $request->is_legal_entity,
                'company_name' => $request->company_name,
                'company_registration_number' => $request->company_registration_number,
                'company_tax_number' => $request->company_tax_number,
                'email' => $request->email,
                'country_id' => $request->country,
                'phone' => $request->phone,
                'city' => $request->city,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'email_addresses' => $request->email_addresses,
                'mail_package' => $request->mail_package,
                'terms_and_conditions' => $request->terms_and_conditions,
                'request_locale' => \App::getLocale(),
                'g-recaptcha-response' => $request['g-recaptcha-response'],
                'user' => 'medianis',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error', [ 'exception' => $e]);
            return false;
        }
    }
}