<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 9.8.2018.
 * Time: 14:12
 */

namespace App;


class OrderDetailParameters
{

    protected $data = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $json
     * @return $this
     */
    public function createFromJson($json)
    {
        $arr = json_decode($json);

        foreach ($arr as $key => $value) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function toJson()
    {
        return json_encode($this->data);
    }

}