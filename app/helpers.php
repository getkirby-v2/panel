<?php

function panel() {
  return panel::instance();
}

function dragText($obj) {

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

function goToErrorView($type = 'index') {
  go(panel()->urls()->index() . '/views/errors/' . $type);
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

function i($icon, $position = null) {

  if(is_string($icon)) {
    echo '<i class="icon' . r($position, ' icon-' . $position) . ' fa fa-' . $icon . '"></i>';
  } else if(is_a($icon, 'Page')) {
    i('file-o', 'left');
  } else if(is_a($icon, 'File')) {

    switch($icon->type()) {
      case 'image':
        i('file-image-o', 'left');
        break;
      case 'document':
        switch($icon->extension()) {
          case 'pdf':
            i('file-pdf-o', 'left');
            break;
          case 'doc':
          case 'docx':
            i('file-word-o', 'left');
            break;
          case 'xls':
            i('file-excel-o', 'left');
            break;
          default:
            i('file-text-o', 'left');
            break;
        }
        break;
      case 'code':
        i('file-code-o', 'left');
        break;
      case 'audio':
        i('file-audio-o', 'left');
        break;
      case 'video':
        i('file-video-o', 'left');
        break;
      default:
        i('file-archive-o', 'left');
        break;
    }

  }

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

function purl($obj, $action = false) {

  if(is_string($obj)) {
    return '#/' . $obj;
  } else if(is_a($obj, 'File')) {
    return '#/files/' . $action . '/' . $obj->page()->id() . '/' . urlencode($obj->filename());
  } else if(is_a($obj, 'Page')) {
    return '#/pages/' . $action . '/' . $obj->id();
  } else if(is_a($obj, 'User')) {
    return '#/users/' . $action . '/' . $obj->username();
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