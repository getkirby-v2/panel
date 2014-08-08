<?php

class SelectField extends BaseField {

  public function __construct() {

    $this->type    = 'select';
    $this->options = array();
    $this->icon    = 'chevron-down';

  }

  public function options() {

    if(is_array($this->options)) {
      return $this->options;
    } else if(!$this->page) {
      return array();
    } else {

      switch($this->options) {
        case 'children':
          $items = $this->page->children();
          break;
        case 'visibleChildren':
          $items = $this->page->children()->visible();
          break;
        case 'invisibleChildren':
          $items = $this->page->children()->invisible();
          break;
        case 'siblings':
          $items = $this->page->siblings()->not($this->page);
          break;
        case 'pages':
          $items = site()->index();
          $items = $items->sortBy('title', 'asc');
          break;
        case 'files':
          $items = $this->page->files();
          break;
        case 'images':
          $items = $this->page->images();
          break;
        case 'documents':
          $items = $this->page->documents();
          break;
        case 'videos':
          $items = $this->page->videos();
          break;
        case 'audio':
          $items = $this->page->audio();
          break;
        case 'code':
          $items = $this->page->code();
          break;
        case 'archives':
          $items = $this->page->archives();
          break;
        default:
          $items = null;
          break;
      }

      if($items) {
        $options = array();

        foreach($items as $item) {

          if(is_a($item, 'Page')) {
            $options[$item->uid()] = (string)$item->title();
          } else if(is_a($item, 'File')) {
            $options[$item->filename()] = (string)$item->filename();
          }

        }

        return $options;

      } else {
        return array();
      }

    }

  }

  public function option($value, $text, $selected = false) {
    return new Brick('option', $this->i18n($text), array(
      'value'    => $value,
      'selected' => $selected
    ));
  }

  public function input() {

    $select = new Brick('select');
    $select->addClass('selectbox');
    $select->attr(array(
      'name'         => $this->name(),
      'id'           => $this->id(),
      'required'     => $this->required(),
      'autocomplete' => $this->autocomplete(),
      'autofocus'    => $this->autofocus(),
      'readonly'     => $this->readonly(),
      'disabled'     => $this->disabled(),
    ));

    if(!$this->required()) {
      $select->append($this->option('', '', $this->value() == ''));
    }

    foreach($this->options() as $value => $text) {
      $select->append($this->option($value, $text, $this->value() == $value));
    }

    $inner = new Brick('div');
    $inner->addClass('selectbox-wrapper');
    $inner->append($select);

    $wrapper = new Brick('div');
    $wrapper->addClass('input input-with-selectbox');
    $wrapper->attr('data-focus', 'true');
    $wrapper->append($inner);

    if($this->readonly()) {
      $wrapper->addClass('input-is-readonly');
    }

    return $wrapper;

  }

  public function validate() {
    return array_key_exists($this->value(), $this->options());
  }

}