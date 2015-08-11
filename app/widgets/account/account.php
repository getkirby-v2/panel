<?php 

$user = site()->user();

return array(
  'title' => array(
    'text'   => l('dashboard.index.account.title'),
    'link'   => purl($user, 'edit'),
  ),
  'options' => array(
    array(
      'text' => l('dashboard.index.account.edit'),
      'icon' => 'pencil',
      'link' => purl($user, 'edit')
    )
  ),
  'html'  => function() use($user) {
    return tpl::load(__DIR__ . DS . 'account.html.php', array(
      'user' => $user
    ));
  }
);