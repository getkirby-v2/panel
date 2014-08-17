<?php

class StructureField extends BaseField {

  static public $assets = array(
    'js' => array(
      'structure.js'
    ),
    'css' => array(
      'structure.css'
    )
  );

  public $fields = array();
  public $entry  = null;

  public function fields() {

    $output = array();

    foreach($this->fields as $k => $v) {
      $v['name']  = $k;
      $v['value'] = '{{' . $k . '}}';
      $output[] = $v;
    }

    return $output;

  }

  public function value() {

    if(is_string($this->value)) {
      $this->value = yaml::decode($this->value);
    }

    return $this->value;

  }

  public function result() {
    $result = parent::result();
    $raw    = (array)json_decode($result);
    $data   = array();
    foreach($raw as $key => $row) {
      unset($row->_id);
      unset($row->_csfr);
      $data[$key] = (array)$row;
    }
    return yaml::encode($data);
  }

  public function entry() {

    if(is_null($this->entry) or !is_string($this->entry)) {
      $html = array();
      foreach($this->fields as $name => $field) {
        $html[] = '{{' . $name . '}}';
      }
      return implode('<br>', $html);
    } else {
      return $this->entry;
    }

  }

  public function label() {
    return null;
  }

  public function headline() {

    $add = new Brick('a');
    $add->html('<i class="icon icon-left fa fa-plus-circle"></i>' . l('fields.structure.add'));
    $add->addClass('structure-add-button label-option');
    $add->attr('#');

    $label = parent::label();
    $label->addClass('structure-label');
    $label->append($add);

    return $label;

  }

  public function content() {
    return tpl::load(__DIR__ . DS . 'template.php', array('field' => $this));
  }

}