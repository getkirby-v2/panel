<?php

class FileModel {

  public $page;
  public $source;

  public function __construct($page, $filename) {

    $this->page = is_a($page, 'PageModel') ? $page : new PageModel($page);

    if(is_a($filename, 'File')) {
      $this->source = $filename;
    } else {
      $this->source = $this->page->source->file($filename);      
    }

    if(!$this->source) {
      throw new Exception('The file could not be found: ' . $filename);
    }

  }

  public function source() {
    return $this->source;
  }

  public function page() {
    return $this->page;
  }

  public function url($action = 'edit') {
    if(empty($action)) $action = 'edit';
    return $this->page()->url('file') . '/' . urlencode($this->source->filename()) . '/' . $action;
  }

  public function previewUrl() {
    return $this->source->url() . '?' . $this->source->modified();    
  }

  public function menu() {
    return new FileMenu($this);    
  }

  public function form($action, $callback) {    
    return panel()->form('files/' . $action, $this, $callback);
  }

  public function filterInput($input) {
    $data = array();
    foreach($this->source->meta()->toArray() as $key => $value) {
      if(strtolower($key) == 'sort') continue;
      $data[$key] = null;
    }
    return array_merge($data, $input);
  }


  public function getFormFields() {
    return $this->page()->blueprint()->files()->fields($this->page()->source())->toArray();
  }

  public function getFormData() {
    return $this->source()->meta()->toArray();    
  }

  public function canHavePreview() {
    $images = array('image/jpeg', 'image/gif', 'image/png');
    return (in_array($this->source->mime(), $images) or $this->source->extension() == 'svg');    
  }  

  public function canHaveThumb() {
    if(!$this->canHavePreview()) {
      return false;
    } else if(kirby()->option('thumbs.driver') == 'gd') {
      if($this->source->width() > 2048 or $this->source->height() > 2048) {
        return false;
      } else {
        return true;
      }
    } else {
      return true;      
    }
  }

  public function rename($name) {

    if($name == $this->source->name()) return true;

    // rename and get the new filename          
    $filename = $this->source->rename($name);
    
    // restore all page caches
    $this->page->reset();

    // search the new file
    $this->source = $this->page->source->file($filename);

    // missing file for some reason
    if(!$this->source) {
      throw new Exception('The file could not be properly renamed');
    }

    // trigger the rename hook
    kirby()->trigger('panel.file.rename', $this->source);          

  }

  public function update($input) {  

    $data = $this->filterInput($input);

    // rename the file if necessary
    $this->rename($data['_name']);

    // remove the name url and info
    unset($data['_name']);
    unset($data['_info']);
    unset($data['_link']);

    if(!empty($data)) {
      $this->source->update($data);          
    }

    kirby()->trigger('panel.file.update', $this->source);

  }

  public function replace() {
    new PageUploader($this->page, $this->source);    
  }

  public function sort($sort) {
    $this->source->update(array('sort' => $sort));
    kirby()->trigger('panel.file.sort', $this->source);
  }

  public function delete() {
    $this->source->delete();
    kirby()->trigger('panel.file.delete', $this->source);    
  }

  public function siblings() {
    return $this->page->source->files();    
  }

  public function index() {
    return $this->siblings()->indexOf($this->source);
  }

  public function next() {
    $next = $this->siblings()->nth($this->index() + 1);
    return $next ? new static($this->page, $next) : false;
  }

  public function prev() {
    $prev = $this->siblings()->nth($this->index() - 1);
    return $prev ? new static($this->page, $prev) : false;
  }

  public function thumb() {
    return $this->source->resize(300, 200)->url();
  }

  public function icon($position = 'left') {

    switch($this->source->type()) {
      case 'image':
        return icon('file-image-o', $position);
        break;
      case 'document':
        switch($this->source->extension()) {
          case 'pdf':
            return icon('file-pdf-o', $position);
            break;
          case 'doc':
          case 'docx':
            return icon('file-word-o', $position);
            break;
          case 'xls':
            return icon('file-excel-o', $position);
            break;
          default:
            return icon('file-text-o', $position);
            break;
        }
        break;
      case 'code':
        return icon('file-code-o', $position);
        break;
      case 'audio':
        return icon('file-audio-o', $position);
        break;
      case 'video':
        return icon('file-video-o', $position);
        break;
      default:
        return icon('file-archive-o', $position);
        break;
    }

  }

  public function dragText() {
    if(c::get('panel.kirbytext') === false) {
      switch($this->source->type()) {
        case 'image':
          return '![' . $this->source->name() . '](' . $this->source->url() . ')';
          break;
        default:
          return '[' . $this->source->filename() . '](' . $this->source->url() . ')';
          break;
      }    
    } else {
      switch($this->source->type()) {
        case 'image':
          return '(image: ' . $this->source->filename() . ')';
          break;
        default:
          return '(file: ' . $this->source->filename() . ')';
          break;
      }
    }
  }

  public function __call($method, $args = null) {
    return call(array($this->source, $method), $args);
  }

}