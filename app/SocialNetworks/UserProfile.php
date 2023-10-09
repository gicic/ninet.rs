<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 26.7.2018.
 * Time: 12:51
 */

namespace App\SocialNetworks;


use Illuminate\Support\Collection;

class UserProfile extends Collection
{
    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }
}