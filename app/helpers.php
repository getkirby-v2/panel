<?php

function panel() {
  return panel::instance();
}

function dragText($obj) {

  if(c::get('panel.kirbytext') === false) {

    if(is_a($obj, 'Page')) {
      return '[' . $obj->title() . '](' . $obj->url() . ')';
    } else if(is_a($obj, 'File')) {
      switch($obj->type()) {
        case 'image':
          return '![' . $obj->name() . '](' . $obj->url() . ')';
          break;
        default:
          return '[' . $obj->filename() . '](' . $obj->url() . ')';
          break;
      }
    }

  } else {

    if(is_a($obj, 'Page')) {
      return '(link: ' . $obj->uri() . ' text: ' . $obj->title() . ')';
    } else if(is_a($obj, 'File')) {
      switch($obj->type()) {
        case 'image':
          return '(image: ' . $obj->filename() . ')';
          break;
        default:
          return '(file: ' . $obj->filename() . ')';
          break;
      }
    }

  }


}

function n($page) {

  if($page->isInvisible()) {
    return '—';
  } else if($page->parent() and $blueprint = blueprint::find($page->parent())) {
    switch($blueprint->pages()->num()->mode()) {
      case 'zero':
        return str::substr($page->title(), 0, 1);
        break;
      case 'date':
        return date('Y/m/d', strtotime($page->num()));
        break;
      default:
        return intval($page->num());
        break;
    }
  } else {
    return intval($page->num());
  }

}

function icon($icon, $position) {

  if(is_string($icon)) {
    return '<i class="icon' . r($position, ' icon-' . $position) . ' fa fa-' . $icon . '"></i>';
  } else if(is_a($icon, 'Page')) {
    $icon = blueprint::find($icon)->icon();
    return icon($icon, 'left');
  } else if(is_a($icon, 'File')) {

    switch($icon->type()) {
      case 'image':
        return icon('file-image-o', 'left');
        break;
      case 'document':
        switch($icon->extension()) {
          case 'pdf':
            return icon('file-pdf-o', 'left');
            break;
          case 'doc':
          case 'docx':
            return icon('file-word-o', 'left');
            break;
          case 'xls':
            return icon('file-excel-o', 'left');
            break;
          default:
            return icon('file-text-o', 'left');
            break;
        }
        break;
      case 'code':
        return icon('file-code-o', 'left');
        break;
      case 'audio':
        return icon('file-audio-o', 'left');
        break;
      case 'video':
        return icon('file-video-o', 'left');
        break;
      default:
        return icon('file-archive-o', 'left');
        break;
    }

  }

}

function i($icon, $position = null) {
  echo icon($icon, $position);
}

function __($var) {
  echo htmlspecialchars($var);
}

function _l($key, $default = null) {
  echo htmlspecialchars(l($key, $default));
}

function _u($obj = '', $action = false) {
  echo purl($obj, $action);
}

function purl($obj = '/', $action = false) {

  $base = panel()->urls()->index();

  if(is_string($obj)) {
    return rtrim($base . '/' . $obj, '/');
  } else if(is_a($obj, 'File')) {
    if($obj->page()->isSite()) {
      return purl($obj->page(), 'file') . '/' . urlencode($obj->filename()) . '/' . $action;
    } else {
      return purl($obj->page(), 'file') . '/' . urlencode($obj->filename()) . '/' . $action;
    }
  } else if(is_a($obj, 'Site')) {

    if($action == 'show') {
      return $base;
    } else {    
      return $base . '/site/' . $action;
    }

  } else if(is_a($obj, 'Page')) {
    return $base . '/pages/' . $obj->id() .  '/' . $action;
  } else if(is_a($obj, 'User')) {
    return $base . '/users/' . $obj->username() . '/' . $action;
  }

}

function layout($file, $data = array()) {
  return new Layout($file, $data);
}

function view($file, $data = array()) {
  return new View($file, $data);
}

function blueprint($page) {
  return $page->blueprint();
}

function fileHasThumbnail($file) {

  if(!in_array(strtolower($file->extension()), array('jpg', 'jpeg', 'gif', 'png'))) {
    return false;
  }

  if(kirby()->option('thumbs.driver') == 'gd') {
    if($file->width() > 2048 or $file->height() > 2048) {
      return false;
    }
  }

  return true;

}


function topbar($view, $input) {
  return new Topbar($view, $input);
}

function screen($view, $topbar = null, $data = array()) {
  return layout('app', array(
    'topbar'  => is_a($topbar, 'Topbar')  ? $topbar : topbar($view, $topbar),
    'content' => is_a($data, 'View')      ? $data   : view($view, $data)
  ));
}

function modal($view, $data = array()) {
  if($view === 'error') $view = 'error/modal';  
  return layout('app', array('content' => view($view, $data)));
}

function addbutton($page) {

  $blueprint = blueprint::find($page);

  if(!api::maxPages($page, $blueprint->pages()->max()) and $page->hasChildren()) {
    $addbutton = new Obj;
    if($blueprint->pages()->template()->count() > 1) {
      $addbutton->url   = purl($page, 'add');
      $addbutton->modal = true;
    } else {
      $addbutton->url   = purl($page, 'add/' . $blueprint->pages()->template()->first()->name());
      $addbutton->modal = false;
    }
  } else {
    $addbutton = false;
  }

  return $addbutton;

}