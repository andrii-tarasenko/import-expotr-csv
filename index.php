<?php

require_once 'Model/Config.php';
require_once 'Controller/MainController.php';

$mainController = new MainController();
$mainController->init(Config::$displayMessage, Config::$period, Config::$perPage, Config::$page);


