<?php 

namespace Kirby\Panel\Models\Page;

use Exception;
use Collection;
use Obj;
use Str;
use Yaml;

class Structure {

  protected $page;
  protected $blueprint;
  protected $field;
  protected $data;
  protected $config;

  public function __construct($page, $field) {

    $this->page = $page;

    if(!$this->page) {
      throw new Exception('Invalid page');
    }

    $this->field     = $field;
    $this->blueprint = $this->page->blueprint();
    $this->config    = $this->blueprint->fields()->get($this->field);

    $this->data();    

  }

  public function page() {
    return $this->page;
  }

  public function fields() {
    $fields = $this->config->fields();

    // make sure that no unwanted options or fields 
    // are being included here
    foreach($fields as $name => $field) {

      // remove all structure fields within structures
      if($field['type'] == 'structure') {
        unset($fields[$name]);

      // remove all buttons from textareas
      } else if($field['type'] == 'textarea') {
        $fields[$name]['buttons'] = false;
      }

      $fields[$name]["page"] = $this->page;
    }

    return $fields;

  }

  public function data() {

    if(!is_null($this->data)) return $this->data;
  
    $this->data = new Collection;    

    // incoming from the text file
    $fromTextFile = (array)$this->page->content()->get($this->field)->yaml();

    // incoming from the page store
    $fromPageStore = (array)yaml::decode($this->page->changes()->get($this->field));

    // create a merged array out of both
    $raw = !$this->page->changes()->exist($this->field) ? $fromTextFile : $fromPageStore;

    foreach($raw as $row) {      
      $this->append($row);
    }

    return $this->data;

  }

  public function find($id) {
    return $this->data()->$id;
  }

  public function delete($id = null) {

    if(is_null($id)) {
      $this->data = new Collection;
    } else {
      unset($this->data()->$id);      
    }

    $this->store();

  }

  public function append($data = array()) {

    // add a unique id if not set yet
    if(!isset($data['id'])) {
      $data['id'] = str::random(32);
    }

    $data = new Obj($data);

    $this->data->append($data->id, $data);

    return $data->id;

  }

  public function add($data = array()) {
    $id = $this->append($data);
    $this->store();
    return $id;
  }

  public function update($id, $data = array()) {

    if($entry = $this->data->$id) {
  
      foreach($data as $key => $val) {
        $entry->$key = $val;
      }
  
      $this->data->$id = $entry;

      $this->store();

    }

  }

  public function sort($ids) {

    $data = new Collection();

    foreach($ids as $id) {
      if($item = $this->find($id)) {
        $data->append($item->id(), $item);        
      }
    }

    $this->data = $data;
    $this->store();

    return $this->data;

  }

  public function store() {
    $this->page->changes()->update($this->field, $this->toYaml());
  }

  public function toArray() {

    $array = array();

    foreach($this->data as $key => $value) {
      $array[$key] = $value->toArray();      
    }

    return $array;

  }

  public function toYaml() {
    return yaml::encode($this->toArray());
  }

}