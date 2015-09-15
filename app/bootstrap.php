<?php

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

load(array(

  // main class
  'kirby\\panel'                                  => 'panel.php',

  // global stuff
  'kirby\\panel\\autocomplete'                    => 'panel' . DS . 'autocomplete.php',
  'kirby\\panel\\roots'                           => 'panel' . DS . 'roots.php',
  'kirby\\panel\\urls'                            => 'panel' . DS . 'urls.php',
  'kirby\\panel\\view'                            => 'panel' . DS . 'view.php',
  'kirby\\panel\\layout'                          => 'panel' . DS . 'layout.php',
  'kirby\\panel\\snippet'                         => 'panel' . DS . 'snippet.php',
  'kirby\\panel\\assets'                          => 'panel' . DS . 'assets.php',
  'kirby\\panel\\installer'                       => 'panel' . DS . 'installer.php',
  'kirby\\panel\\widgets'                         => 'panel' . DS . 'widgets.php',
  'kirby\\panel\\topbar'                          => 'panel' . DS . 'topbar.php',

  // controllers
  'kirby\\panel\\controllers\\base'               => 'panel' . DS . 'controllers' . DS . 'base.php',
  'kirby\\panel\\controllers\\field'              => 'panel' . DS . 'controllers' . DS . 'field.php',

  // form
  'kirby\\panel\\form'                            => 'panel' . DS . 'form.php',
  'kirby\\panel\\form\\fieldoptions'              => 'panel' . DS . 'form' . DS . 'fieldoptions.php',

  // models
  'kirby\\panel\\models\\site'                         => 'panel' . DS . 'models' . DS . 'site.php',
  'kirby\\panel\\models\\page'                         => 'panel' . DS . 'models' . DS . 'page.php',
  'kirby\\panel\\models\\page\\addbutton'              => 'panel' . DS . 'models' . DS . 'page' . DS . 'addbutton.php',
  'kirby\\panel\\models\\page\\menu'                   => 'panel' . DS . 'models' . DS . 'page' . DS . 'menu.php',
  'kirby\\panel\\models\\page\\editor'                 => 'panel' . DS . 'models' . DS . 'page' . DS . 'editor.php',
  'kirby\\panel\\models\\page\\changes'                => 'panel' . DS . 'models' . DS . 'page' . DS . 'changes.php',
  'kirby\\panel\\models\\page\\uploader'               => 'panel' . DS . 'models' . DS . 'page' . DS . 'uploader.php',
  'kirby\\panel\\models\\page\\structure'              => 'panel' . DS . 'models' . DS . 'page' . DS . 'structure.php',
  'kirby\\panel\\models\\page\\blueprint'              => 'panel' . DS . 'models' . DS . 'page' . DS . 'blueprint.php',
  'kirby\\panel\\models\\page\\blueprint\\pages'       => 'panel' . DS . 'models' . DS . 'page' . DS . 'blueprint' . DS . 'pages.php',
  'kirby\\panel\\models\\page\\blueprint\\files'       => 'panel' . DS . 'models' . DS . 'page' . DS . 'blueprint' . DS . 'files.php',
  'kirby\\panel\\models\\page\\blueprint\\fields'      => 'panel' . DS . 'models' . DS . 'page' . DS . 'blueprint' . DS . 'fields.php',
  'kirby\\panel\\models\\page\\blueprint\\field'       => 'panel' . DS . 'models' . DS . 'page' . DS . 'blueprint' . DS . 'field.php',
  'kirby\\panel\\models\\file'                         => 'panel' . DS . 'models' . DS . 'file.php',
  'kirby\\panel\\models\\file\\menu'                   => 'panel' . DS . 'models' . DS . 'file' . DS . 'menu.php',
  'kirby\\panel\\models\\user'                         => 'panel' . DS . 'models' . DS . 'user.php',
  'kirby\\panel\\models\\user\\avatar'                 => 'panel' . DS . 'models' . DS . 'user' . DS . 'avatar.php',
  'kirby\\panel\\models\\user\\history'                => 'panel' . DS . 'models' . DS . 'user' . DS . 'history.php',
  'kirby\\panel\\models\\user\\permission'             => 'panel' . DS . 'models' . DS . 'user' . DS . 'permission.php',

  // collections
  'kirby\\panel\\collections\\users'              => 'panel' . DS . 'collections' . DS . 'users.php',
  'kirby\\panel\\collections\\files'              => 'panel' . DS . 'collections' . DS . 'files.php',
  'kirby\\panel\\collections\\children'           => 'panel' . DS . 'collections' . DS . 'children.php',

), __DIR__ . DS . 'src');


// some fallbacks for possible namespace issues and convenience
class_alias('Kirby\\Panel\\Form\\FieldOptions', 'FieldOptions');
class_alias('Kirby\\Panel', 'Panel');

include(__DIR__ . DS . 'vendor' . DS . 'autoload.php');
include(__DIR__ . DS . 'helpers.php');

