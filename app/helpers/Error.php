<?php
namespace App\helpers;


class Error
{

    public $errors = [];

    public function __construct($errors = [])
    {
        if (isset($_SESSION['ERRORS'])) {
            $this->errors = $_SESSION['ERRORS'];
            unset($_SESSION['ERRORS']); 
        } else {
            $this->errors = $errors;
        }
    }

    public function any()
    {
        return !empty($this->errors);
    }

    public function all()
    {
        return $this->errors;
    }
}
