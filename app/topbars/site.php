<?php 

return function($topbar, $site) {

  if($topbar->view == 'options/index') {
    $topbar->append(purl('options'), l('metatags'));
  }

  if($topbar->view == 'subpages/index') {
    $topbar->append(purl($site, 'subpages'), l('subpages'));    
  }
 
  $topbar->html .= new Snippet('languages');
  $topbar->html .= new Snippet('searchtoggle', array(
    'search' => purl($site, 'search'),
    'close'  => $topbar->view == 'pages/search' ? purl($site, 'show') : false
  ));    

};