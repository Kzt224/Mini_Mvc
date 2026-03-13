<?php

namespace App\helpers;


class Cache
{

    public $caches = [];

    public function __construct($cache = [])
    {
        if (isset($_SESSION['CACHE'])) {
            $this->caches = $_SESSION['CACHE'];
            unset($_SESSION['CACHE']);
        } else {
            $this->caches = $cache;
        }
    }

    public function any()
    {
        return !empty($this->caches);
    }

    public function all()
    {
        return $this->caches;
    }
}
