<?php 

return function($topbar, $page) {

  if($page->isSite()) {

    if($topbar->view == 'options/index') {
      $topbar->append(purl('options'), l('metatags'));
    }

  } else {

    foreach($page->breadcrumb() as $item) {
      $topbar->append($item->url(), $item->title());
    }

    $topbar->append($page->url(), $page->title());

  }
  
  if($topbar->view == 'subpages/index') {
    $topbar->append($page->url('subpages'), l('subpages'));    
  }
 
  $topbar->html .= new Snippet('languages');
  $topbar->html .= new Snippet('searchtoggle', array(
    'search' => $page->url('search'),
    'close'  => $topbar->view == 'pages/search' ? $page->url() : false
  ));    

};