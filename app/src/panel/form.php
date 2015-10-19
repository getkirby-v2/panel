<?php

namespace Kirby\Panel;

use A;
use Brick;
use Collection;
use Dir;
use F;
use R;
use Str;

use JShrink\Minifier;

class Form extends Brick {

  static public $root  = array();
  static public $files = null;

  public $tag         = 'form';
  public $fields      = array();
  public $values      = array();
  public $message     = null;
  public $buttons     = null;
  public $centered    = false;
  public $parentField = false;

  public function __construct($fields = array(), $values = array(), $parent = false) {

    $this->fields = new Collection;

    // if Form is part of a structureField, set structureField name
    $this->parentField = $parent;

    $this->values($values);
    $this->fields($fields);
    $this->buttons();
    $this->attr('method', 'post');
    $this->attr('action', panel()->urls()->current());
    $this->addClass('form');

  }

  public function method($method = null) {
    return $this->attr('method', $method);
  }

  public function action($action = null) {
    return $this->attr('action', $action);
  }

  public function fields($fields = null) {

    if(is_null($fields)) return $this->fields;

    foreach($fields as $name => $field) {

      if($name == 'title') $field['type'] = 'title';

      $name = str_replace('-','_', str::lower($name));

      $field['name']    = $name;
      $field['default'] = a::get($field, 'default', null);
      $field['value']   = a::get($this->values(), $name, $field['default']);

      // Pass through parent field name (structureField)
      $field['parentField'] = $this->parentField;

      $this->fields->append($name, static::field($field['type'], $field));

    }

    return $this;

  }

  public function values($values = null) {
    if(is_null($values)) return array_merge($this->values, r::data());
    $this->values = array_merge($this->values, $values);
    return $this;
  }

  public function value($name) {
    return a::get($this->values(), $name, null);
  }

  public function validate() {

    $errors = array();

    foreach($this->fields() as $field) {

      $name  = $field->name();
      $value = $this->value($name);

      if($field->required() and $value == '') {
        $field->error = true;
      } else if($value !== '' and $field->validate() === false) {
        $field->error = true;
      }

    }

  }

  public function isValid() {
    return $this->fields()->filterBy('error', true)->count() == 0;
  }

  public function message($type, $text) {

    $this->message = new Brick('div');
    $this->message->addClass('message');

    if($type == 'error') {
      $this->message->addClass('message-is-alert');      
    } else {
      $this->message->addClass('message-is-notice');
    }

    $this->message->append(function() use($text) {

      $content = new Brick('span');
      $content->addClass('message-content');
      $content->text($text);

      return $content;

    });

    return $this->message;

  }

  public function alert($text) {
    $this->message('error', $text);
  }

  public function notify($text) {
    $this->message('success', $text);
  }

  public function serialize() {

    $data = array();

    foreach($this->fields() as $field) {
      $result = $field->result();
      if(!is_null($result)) $data[$field->name()] = $result;
    }

    return $data;

  }

  public function toArray() {
    return $this->serialize();
  }

  static public function files() {

    if(!is_null(static::$files)) return static::$files;

    static::$files = array();

    $files = dir::read(static::$root['default']);

    if(isset(static::$root['custom'])) {
      $files = array_merge($files, dir::read(static::$root['custom']));
    }

    foreach($files as $file) {

      $name = strtolower($file) . 'field';

      if(isset(static::$root['custom']) and is_dir(static::$root['custom'] . DS . $file)) {
        $root = static::$root['custom'] . DS . $file . DS . $file . '.php';
      } else {
        $root = static::$root['default'] . DS . $file . DS . $file . '.php';
      }

      if(file_exists($root)) {
        static::$files[$name] = $root;
      }

    }

    return static::$files;

  }

  static public function assets($type, $compress = true) {

    $files    = static::files();
    $output   = array();

    foreach(static::files() as $field => $file) {
      if(isset($field::$assets) and isset($field::$assets[$type])) {
        foreach($field::$assets[$type] as $f) {
          $output[] = f::read(dirname($file) . DS . 'assets' . DS . $type . DS . $f);
        }
      }
    }

    $output = implode(PHP_EOL . PHP_EOL, $output);

    if($compress) {
      if($type == 'css') {
        $output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $output);
        $output = trim(str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $output));        
      } else {
        $output = Minifier::minify($output, array('flaggedComments' => false));
      }
    }

    return $output;

  }

  static public function js($compress = true) {
    return static::assets('js', $compress);
  }

  static public function css($compress = true) {
    return static::assets('css', $compress);
  }

  static public function setup($defaultFieldsRoot, $customFieldsRoot = null) {

    static::$root['default'] = $defaultFieldsRoot;
    static::$root['custom']  = $customFieldsRoot;

    $classes = static::files();

    load($classes);

    foreach($classes as $classname => $root) {
      if(method_exists($classname, 'setup')) {
        call(array($classname, 'setup'));
      }
    }

  }

  public function style($style) {

    switch($style) {
      case 'centered':
        $this->centered = true;
        $this->buttons->cancel = '';
        break;
      case 'upload':
        $this->centered = true;
        $this->buttons->submit = '';
        $this->attr('enctype', 'multipart/form-data');
        break;
      case 'delete':
        $this->buttons->submit->addClass('btn-negative');
        $this->buttons->submit->attr('autofocus', true);
        $this->buttons->submit->val(l('delete'));
        break;
      case 'editor':

        $kirbytext = kirby()->option('panel.kirbytext', true);

        $this->data('textarea', get('textarea'));    
        $this->data('autosubmit', 'false');
        $this->data('kirbytext', r($kirbytext, 'true', 'false'));
        $this->buttons->submit->val(l('insert'));
        break;
    }

  }

  public function redirect() {
    return get('_redirect');
  }

  public function cancel() {
    if($redirect = $this->redirect()) {
      $this->buttons->cancel->href = purl($redirect);
    } else {    
      $this->buttons->cancel->href = call('purl', func_get_args());
    }
  }

  static public function field($type, $options = array()) {

    $class = $type . 'field';
    $field = new $class;

    foreach($options as $key => $value) {
      $field->$key = $value;
    }

    return $field;

  }

  public function buttons() {

    if(!is_null($this->buttons)) return $this->buttons;

    $this->buttons = new Collection();

    $button = new Brick('input', null);
    $button->addClass('btn btn-rounded');

    $cancel = clone $button;
    $cancel->tag('a');
    $cancel->addClass('btn-cancel');
    $cancel->attr('href', '#cancel');
    $cancel->text(l('cancel'));

    $this->buttons->append('cancel', $cancel);

    $submit = clone $button;
    $submit->attr('type', 'submit');
    $submit->addClass('btn-submit');
    $submit->data('saved', l('saved'));
    $submit->val(l('save'));        

    $this->buttons->append('submit', $submit);

    return $this->buttons;

  }

  public function on($action, $callback) {

    // auto-trigger the submit event when the form is being echoed
    if(r::is('post')) {    
      $callback($this);
    } 

    $this->fields->append('csrf', static::field('hidden', array(
      'name'  => 'csrf',
      'value' => panel()->csrf()
    )));

  }

  public function toHTML() {
    
    if($this->message) {
      $this->append($this->message);      
    }
    
    $fieldset = new Brick('fieldset');
    $fieldset->addClass('fieldset field-grid cf');

    foreach($this->fields() as $field) $fieldset->append($field);
  
    // pass the redirect url   
    $redirectField = new Brick('input');
    $redirectField->type  = 'hidden';
    $redirectField->name  = '_redirect';
    $redirectField->value = $this->redirect();
    $fieldset->append($redirectField);

    $this->append($fieldset);

    $buttons = new Brick('fieldset');
    $buttons->addClass('fieldset buttons');

    if($this->centered) {
      $buttons->addClass('buttons-centered');
    }

    foreach($this->buttons() as $button) $buttons->append($button);

    $this->append($buttons);

    return $this;

  }

  public function __toString() {
    
    $this->toHTML();
    return parent::__toString();    

  }

}
