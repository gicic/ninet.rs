<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 5.7.2018.
 * Time: 13:19
 */

namespace App;


use Spatie\MissingPageRedirector\Redirector\Redirector;
use Symfony\Component\HttpFoundation\Request;

class UrlRedirector implements Redirector
{
    public function getRedirectsFor(Request $request): array
    {
        // TODO: Implement getRedirectsFor() method.
    }


}