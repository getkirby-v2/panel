<?php 

$site      = site();
$blueprint = blueprint::find($site);
$pages     = api::subpages($site->children(), $blueprint);
$addbutton = !api::maxPages($site, $blueprint->pages()->max());
$options   = array(
  array(
    'text' => l('dashboard.index.pages.edit'),
    'icon' => 'pencil',
    'link' => '#/subpages/index/'
  )
);

if($addbutton) {
  $options[] = array(
    'text' => l('dashboard.index.pages.add'),
    'icon' => 'plus-circle',
    'link' => '#/pages/add/',
    'key'  => '+'
  );
}

return array(
  'title' => array(
    'text'       => l('dashboard.index.pages.title'),
    'link'       => '#/subpages/index/',
    'compressed' => true
  ),
  'options' => $options,
  'html'  => function() use($pages) {
    return tpl::load(__DIR__ . DS . 'pages.html.php', array(
      'pages' => $pages
    ));
  }
);