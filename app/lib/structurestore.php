<?php 

class StructureStore {

  protected $page;
  protected $blueprint;
  protected $field;
  protected $data;
  protected $config;

  public function __construct(Page $page, $field) {

    $this->page = $page;

    if(!$this->page) {
      throw new Exception('Invalid page');
    }

    $this->field     = $field;
    $this->blueprint = blueprint::find($this->page);
    $this->config    = $this->blueprint->fields()->get($this->field);

    $this->data();    

  }

  public function fields() {
    return $this->config->fields();
  }

  public function data() {

    if(!is_null($this->data)) return $this->data;
  
    $this->data = new Collection;    

    // incoming from the text file
    $fromTextFile = (array)$this->page->content()->get($this->field)->yaml();

    // incoming from the page store
    $fromPageStore = (array)yaml::decode(PageStore::fetch($this->page, $this->field));

    // create a merged array out of both
    $raw = !PageStore::has($this->page, $this->field) ? $fromTextFile : $fromPageStore;

    foreach($raw as $row) {      
      $this->append

    ($row);
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

  }

  public function add($data = array()) {
    $this->append($data);
    $this->store();
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
    $pagestore = pagestore::fetch($this->page);
    $pagestore[$this->field] = $this->toYaml();
    pagestore::update($this->page, $pagestore);
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