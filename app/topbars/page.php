<?php 

return function($topbar, $page) {

  foreach($page->parents()->flip() as $item) {
    $topbar->append(purl($item, 'show'), $item->title());
  }

  $topbar->append(purl($page, 'show'), $page->title());
  
  if($topbar->view == 'subpages/index') {
    $topbar->append(purl($page, 'subpages'), l('subpages'));    
  }
 
  $topbar->html .= new Snippet('languages');
  $topbar->html .= new Snippet('searchtoggle', array(
    'search' => purl($page, 'search'),
    'close'  => $topbar->view == 'pages/search' ? purl($page, 'show') : false
  ));    

};