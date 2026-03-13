<?php

namespace App\Controllers;

use App\Http\Request;

class Controller extends ViewController
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->request->validateCsrf();
        }
    }
    public function Redirect($name)
    {
        $old = $this->request->all();
        if ($this->request->getError()) {
            $errors = $this->request->getError();
            $_SESSION['ERRORS'] = $errors[0];
            $_SESSION['CACHE'] = $old;
            $this->view($name);
        } else {
            header("Location: " . BASE_URL . $name . "/");
        }
    }
}
