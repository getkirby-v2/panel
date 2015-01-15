<?php

class Form extends Brick {

  static public $root  = array();
  static public $files = null;

  public $tag      = 'form';
  public $fields   = array();
  public $values   = array();
  public $alert    = null;
  public $save     = true;
  public $cancel   = true;
  public $centered = false;
  public $back     = false;

  public function __construct($fields = array(), $values = array()) {

    $this->fields = new Collection;

    $this->values($values);
    $this->fields($fields);
    $this->attr('method', 'post');
    $this->addClass('form');
    $this->on('submit', function($form) {
      $form->validate();
    });

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

      if($field->required() and empty($value)) {
        $field->error = true;
      } else if($value != '' and !$field->validate()) {
        $field->error = true;
      }

    }

  }

  public function isValid() {
    return $this->fields()->filterBy('error', true)->count() == 0;
  }

  public function alert($alert = null) {

    if(!is_null($alert)) {
      $this->alert = $alert;
      return $this;
    }

    if(is_null($this->alert)) return null;

    $message = $this->alert;

    $alert = new Brick('div');
    $alert->addClass('message message-is-alert');
    $alert->append(function() use($message) {

      $content = new Brick('span');
      $content->addClass('message-content');
      $content->text($message);

      return $content;

    });

    $alert->append(function() {

      $toggle = new Brick('span');
      $toggle->addClass('message-toggle');
      $toggle->html('<i>&times;</i>');
      return $toggle;

    });

    return $alert;

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
        static::$files[$name] = static::$root['custom'] . DS . $file . DS . $file . '.php';
      } else {
        static::$files[$name] = static::$root['default'] . DS . $file . DS . $file . '.php';
      }

    }

    return static::$files;

  }

  static public function assets($type, $compress = true) {

    $files  = static::files();
    $output = array();

    foreach(static::files() as $field => $file) {

      if(isset($field::$assets) and isset($field::$assets[$type])) {
        foreach($field::$assets[$type] as $f) {
          $output[] = f::read(dirname($file) . DS . 'assets' . DS . $type . DS . $f);
        }
      }

    }

    $output = implode(PHP_EOL . PHP_EOL, $output);

    if($compress) {
      $output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $output);
      $output = trim(str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $output));
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

    load(static::files());

    spl_autoload_register(function($class) use($defaultFieldsRoot, $customFieldsRoot) {
      $class = strtolower($class);
      if(str::contains($class, 'field')) {
        $type    = str_replace('field', '', $class);
        $file    = $type . DS . $type . '.php';
        $custom  = $customFieldsRoot . DS . $file;
        $default = $defaultFieldsRoot . DS . $file;
        if($customFieldsRoot and file_exists($custom)) {
          include($custom);
        } else if(file_exists($default)) {
          include($default);
        }
      }
    });

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

    $fieldset = new Brick('fieldset');
    $fieldset->addClass('fieldset buttons cf');

    if($this->centered) {
      $fieldset->addClass('buttons-centered');
    }

    $button = new Brick('input', null);
    $button->addClass('btn btn-rounded');

    if($this->cancel) {

      $cancel = clone $button;
      $cancel->tag('a');
      $cancel->addClass('btn-cancel');
      $cancel->attr('href', $this->back);
      $cancel->text($this->cancel === true ? l::get('cancel') : $this->cancel);

      $fieldset->append($cancel);

    }

    if($this->save) {

      $submit = clone $button;
      $submit->attr('type', 'submit');
      $submit->addClass('btn-submit');
      $submit->data('saved', l::get('saved'));
      $submit->val($this->save === true ? l::get('save') : $this->save);

      $fieldset->append($submit);

    }

    return ($this->save or $this->cancel) ? $fieldset : null;

  }

  public function __toString() {

    // auto-trigger the submit event when the form is being echoed
    if(get('_csfr') and csfr(get('_csfr'))) {
      $this->trigger('submit');
    }

    $this->append($this->alert());

    $fieldset = new Brick('fieldset');
    $fieldset->addClass('fieldset field-grid cf');

    foreach($this->fields() as $field) $fieldset->append($field);

    $this->append($fieldset);
    $this->append($this->buttons());
    $this->append(static::field('hidden', array(
      'name'  => '_csfr',
      'value' => csfr()
    )));

    return parent::__toString();
  }

}