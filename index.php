<?php
/**
 * Created by PhpStorm.
 * User: badikirwan
 * Date: 11/21/17
 * Time: 1:50 AM
 */

use \Slim\Http\Request;
use \Slim\Http\Response;

require 'vendor/autoload.php';
require 'src/config.php';

$app = new \Slim\App();

$app->get('/', function (Request $request, Response $response) use ($con) {
    echo "Welcome to API IKA-PMII";
});

$app->run();