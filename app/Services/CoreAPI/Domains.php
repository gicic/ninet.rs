<?php


namespace App\Services\CoreAPI;


class Domains
{
    /**
     * is available
     *
     * @param $domain_extension
     * @param $sld
     * @param $tld
     * @return bool|mixed
     */
    public static function isAvailable($sld, $tld)
    {
        try {
            return \App\Services\CoreAPI\Facades\CoreAPI::makeRequest('get', '/domain/is-available', [
                'domain_sld' => $sld,
                'domain_tld' => $tld,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error is available', [ 'domain_name' => $sld . $tld, 'exception' => $e]);
            return false;
        }
    }
}
