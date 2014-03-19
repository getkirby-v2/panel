<?php 

define('DS', DIRECTORY_SEPARATOR);

// load the kirby bootstrapper
include(dirname(__DIR__) . DS . 'kirby' . DS . 'bootstrap.php');

// load the panel bootstrapper
include(__DIR__ . DS . 'app' . DS . 'bootstrap.php');

app::configure(__DIR__);

try {
  app::launch();
} catch(Exception $e) {
  dump($e->getMessage());
}