<?php 

return function($topbar, $files) {

  $page = new PageModel($files->page());

  if($page->isSite()) {
    $topbar->append(purl('options'), l('metatags'));
  }

  $pagebar = require(__DIR__ . DS . 'page.php');
  $pagebar($topbar, $page);    

  $topbar->append(purl($page, 'files'), l('files'));
 
};