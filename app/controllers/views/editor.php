<?php

class EditorController extends Controller {

  public function link($uri) {

    return view('editor/link', array(
      'text' => get('text'),
      'url'  => get('url'),
      'back' => purl($uri)
    ));

  }

  public function email($uri) {

    return view('editor/email', array(
      'text'    => get('text'),
      'address' => get('address'),
      'back'    => purl($uri)
    ));

  }

  public function image($uri) {

    return view('editor/image', array(
      'p'      => $this->page($uri),
      'back'   => purl($uri)
    ));

  }

  public function file($uri) {

    return view('editor/file', array(
      'p'    => $this->page($uri),
      'back' => purl($uri)
    ));

  }

  public function structure($id, $fieldName) {

    $page = empty($id) ? site() : page($id);

    if(!$page) throw new Exception('The page could not be found');

    $blueprint  = blueprint::find($page);
    $field      = null;

    // make sure to get fields by case insensitive field names
    foreach($blueprint->fields() as $f) {
      if(strtolower($f->name) == strtolower($fieldName)) {
        $field = $f;
      }
    }

    if(!$field) throw new Exception('The field could not be found');

    $fields     = new Blueprint\Fields($field->fields(), $page);
    $fields     = $fields->toArray();

    foreach($fields as $key => $field) {
      if($field['type'] == 'textarea') $fields[$key]['buttons'] = false;
    }

    $form       = new Form($fields);
    $form->save = get('_id') ? l('fields.structure.save') : l('fields.structure.add');

    return view('editor/structure', array(
      'page' => $page,
      'form' => $form
    ));

  }

  protected function id($uri) {
    return implode('/', array_slice(str::split(trim($uri, '/'), '/'), 2));
  }

  protected function page($uri) {
    if($page = page($this->id($uri))) {
      return $page;
    } else {
      throw new Exception('The page could not be found');
    }
  }

}