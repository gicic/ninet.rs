<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 27.7.2018.
 * Time: 13:19
 */

namespace App\Traits;


trait BindableModel
{

    public function __get($key)
    {
        if($key == 'boundModel') {
            return (new $this->model_type)->find($this->model_id);
        }

        return parent::__get($key);
    }

}