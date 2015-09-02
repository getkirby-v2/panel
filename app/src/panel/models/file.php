<?php

namespace Kirby\Panel\Models;

use C;
use Kirby\Panel\Models\File\Menu;
use Kirby\Panel\Models\Page\Uploader;

class File extends \File {

  public function url($action = null) {
    if(empty($action)) {
      return parent::url();
    } else if($action == 'preview') {
      return parent::url() . '?' . $this->modified();    
    } else {
      return $this->page()->url('file') . '/' . rawurlencode($this->filename()) . '/' . $action;      
    }
  }

  public function menu() {
    return new Menu($this);    
  }

  public function form($action, $callback) {    
    return panel()->form('files/' . $action, $this, $callback);
  }

  public function filterInput($input) {
    $data = array();
    foreach($this->meta()->toArray() as $key => $value) {
      if(strtolower($key) == 'sort') continue;
      $data[$key] = null;
    }
    return array_merge($data, $input);
  }


  public function getFormFields() {
    return $this->page()->blueprint()->files()->fields($this->page())->toArray();
  }

  public function getFormData() {
    return $this->meta()->toArray();    
  }

  public function canHavePreview() {
    $images = array('image/jpeg', 'image/gif', 'image/png');
    return (in_array($this->mime(), $images) or $this->extension() == 'svg');    
  }  

  public function canHaveThumb() {
    if(!$this->canHavePreview()) {
      return false;
    } else if(kirby()->option('thumbs.driver') == 'gd') {
      if($this->width() > 2048 or $this->height() > 2048) {
        return false;
      } else {
        return true;
      }
    } else {
      return true;      
    }
  }

  public function rename($name) {

    if($name == $this->name()) return true;

    // rename and get the new filename          
    $filename = parent::rename($name);

    // trigger the rename hook
    kirby()->trigger('panel.file.rename', $this);          

  }

  public function update($input = array(), $sort = null) {  

    if($input == 'sort') {
      parent::update(array('sort' => $sort));
      kirby()->trigger('panel.file.sort', $this);
      return true;
    }

    $data = $this->filterInput($input);

    // rename the file if necessary
    if(!empty($data['_name'])) {
      $filename = $this->rename($data['_name']);      
    }

    // remove the name url and info
    unset($data['_name']);
    unset($data['_info']);
    unset($data['_link']);

    if(!empty($data)) {
      parent::update($data);          
    }

    kirby()->trigger('panel.file.update', $this);

  }

  public function replace() {
    new Uploader($this->page, $this);    
  }

  public function delete() {
    parent::delete();
    kirby()->trigger('panel.file.delete', $this);    
  }

  public function thumb() {
    return $this->resize(300, 200)->url();
  }

  public function icon($position = 'left') {

    switch($this->type()) {
      case 'image':
        return icon('file-image-o', $position);
        break;
      case 'document':
        switch($this->extension()) {
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
      switch($this->type()) {
        case 'image':
          return '![' . $this->name() . '](' . parent::url() . ')';
          break;
        default:
          return '[' . $this->filename() . '](' . parent::url() . ')';
          break;
      }    
    } else {
      switch($this->type()) {
        case 'image':
          return '(image: ' . $this->filename() . ')';
          break;
        default:
          return '(file: ' . $this->filename() . ')';
          break;
      }
    }
  }

  public function topbar($topbar) {

    $this->files()->topbar($topbar);

    $topbar->append($this->url(), $this->filename());
   
  }

}