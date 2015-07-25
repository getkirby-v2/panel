<?php 

class PageMenu {

  public $page;
  public $blueprint;
  public $position;

  public function __construct($page, $position = 'sidebar') {
    $this->page      = $page;
    $this->blueprint = blueprint::find($page);
    $this->position  = $position;
  }

  public function isDeletable() {
    return (!$this->page->hasChildren() and $this->page->isDeletable() and $this->blueprint->deletable());
  }

  public function previewUrl() {
    // create the preview link
    if($previewSetting = $this->blueprint->preview()) {
      switch($previewSetting) {
        case 'parent':
          return $this->page->parent() ? $this->page->parent()->url() : $this->page->url();
          break;
        case 'first-child':
          return $this->page->children()->first() ? $this->page->children()->first()->url() : false;
          break;
        case 'last-child':
          return $this->page->children()->last()  ? $this->page->children()->last()->url() : false;
          break;
        default:
          return $this->page->url();
          break;
      }
    } else {
      return false;
    }
  }

  public function item($icon, $label, $attr = array()) {

    $a = new Brick('a', '', $attr);
    $a->append(icon($icon, 'left'));
    $a->append(l($label));

    $parent = $this->page->parent();

    if($this->position == 'context') {    
      if($parent->isSite()) {
        $a->data('modal-return-to', purl('/'));
      } else {
        $a->data('modal-return-to', purl($parent, 'show'));
      }
    }

    $li = new Brick('li');
    $li->append($a);

    return $li;

  }

  public function previewOption() {  
    if($previewUrl = $this->previewUrl()) {
      return $this->item('play-circle-o', 'pages.show.preview', array(
        'href'          => $previewUrl,
        'target'        => '_blank',
        'title'         => 'p',
        'data-shortcut' => 'p',
      ));
    } else {
      return false;
    }
  }

  public function editOption() {  
    if($this->position == 'context') {
      return $this->item('pencil', 'pages.show.subpages.edit', array(
        'href' => purl($this->page, 'show'),
      ));      
    }
  }

  public function statusOption() {

    if(!$this->page->isErrorPage()) {

      if($this->page->isInvisible()) {
        $icon  = 'toggle-off';
        $label = 'pages.show.invisible';
      } else {
        $icon  = 'toggle-on';
        $label = 'pages.show.visible';      
      }

      return $this->item($icon, $label, array(
        'href'       => purl($this->page, 'toggle'),
        'data-modal' => true,
      ));

    } else {
      return false;
    }


  } 

  public function urlOption() {
    if(!$this->page->isHomePage() and !$this->page->isErrorPage()) {
      return $this->item('chain', 'pages.show.changeurl', array(
        'href'          => purl($this->page, 'url'),
        'title'         => 'u',
        'data-shortcut' => 'u',
        'data-modal'    => true,
      ));      
    } else {
      return false;
    }
  }

  public function deleteOption() {
    if($this->isDeletable()) {
      return $this->item('trash-o', 'pages.show.delete', array(
        'href'                 => purl($this->page, 'delete'),
        'title'                => '#',
        'data-shortcut'        => '#',
        'data-modal'           => true,
        'data-modal-return-to' => $this->page->parent()->isSite() ? purl('/') : false,
      ));
    } else {
      return false;
    }
  }

  public function html() {

    $list = new Brick('ul');
    $list->addClass('nav nav-list');

    if($this->position == 'sidebar') {
      $list->addClass('sidebar-list');
    } else {
      $list->addClass('dropdown-list');
    }

    $list->append($this->previewOption());
    $list->append($this->editOption());
    $list->append($this->statusOption());
    $list->append($this->urlOption());
    $list->append($this->deleteOption());

    if($this->position == 'context') {
      return '<nav class="dropdown dropdown-dark contextmenu">' . $list . '</nav>';
    } else {
      return $list;
    }

  }

  public function __toString() {
    return (string)$this->html();
  }

}