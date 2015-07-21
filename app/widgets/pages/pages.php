<?php 

$site      = site();
$blueprint = blueprint::find($site);
$pages     = api::subpages($site->children(), $blueprint);
$addbutton = addbutton($site);
$options   = array(
  array(
    'text' => l('dashboard.index.pages.edit'),
    'icon' => 'pencil',
    'link' => purl($site, 'subpages')
  )
);

if($addbutton) {
  $options[] = array(
    'text'  => l('dashboard.index.pages.add'),
    'icon'  => 'plus-circle',
    'link'  => $addbutton->url,
    'key'   => '+',
    'modal' => true,
  );
}

return array(
  'title' => array(
    'text'       => l('dashboard.index.pages.title'),
    'link'       => purl($site, 'subpages'),
    'compressed' => true
  ),
  'options' => $options,
  'html'  => function() use($pages) {
    return tpl::load(__DIR__ . DS . 'pages.html.php', array(
      'pages' => $pages
    ));
  }
);