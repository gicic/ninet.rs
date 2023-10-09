<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 28.6.2018.
 * Time: 11:18
 */

namespace App;


class CommonOffer
{
    public $id;
    public $title;
    public $titleHtml;
    public $route;
    public $description;
    public $items;
    public $colspan;
    public $category;
    public $periods;
    public $tabs;
    public $billingType;

    /**
     * CommonOffer constructor.
     * @param $title
     * @param $route
     */
    public function __construct($title = null, $route = null)
    {
        $this->title = $title;
        $this->route = $route;
    }

    public function __set($name, $value)
    {
        if ($name === 'cartRoute') {
            $this->cartRoute = $value;
        }
    }


}