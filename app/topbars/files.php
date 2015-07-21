<?php 

return function($topbar, $files) {

  $page = $files->page();

  if($page->isSite()) {

    $topbar->append(purl('options'), l('metatags'));

    $sitebar = require(__DIR__ . DS . 'site.php');
    $sitebar($topbar, $page);    

  } else {
    $pagebar = require(__DIR__ . DS . 'page.php');
    $pagebar($topbar, $page);    
  }

  $topbar->append(purl($page, 'files'), l('files'));
 
};