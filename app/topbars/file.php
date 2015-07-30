<?php 

return function($topbar, $file) {

  $files = $file->files();

  $filesbar = require(__DIR__ . DS . 'files.php');
  $filesbar($topbar, $files);

  $topbar->append($file->url(), $file->filename());
 
};