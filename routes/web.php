<?php

use App\Controllers\HomeController;

$router->get("/", [HomeController::class, 'index']);         
$router->get("/user",[HomeController::class,'showCreate']);
$router->post("/user",[HomeController::class,'store']);
$router->get("/user/{id}", [HomeController::class, 'about']);
$router->post("/user/{id}/delete",[HomeController::class,'delete']);
$router->get("/user/{id}/update",[HomeController::class,'showEdit']);
$router->post("/user/{id}/update",[HomeController::class,'update']);